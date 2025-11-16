<?php

namespace App\Http\Controllers;

use App\Models\Procedure;
use App\Models\Category;
use App\Models\ProcedureAttachment;
use App\Models\ProcedureChecklist;
use App\Models\User;
use App\Notifications\NewProcedureNotification;
use App\Notifications\ProcedureApprovalNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProcedureController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Procedure::with(['category', 'creator']);

        // Filter by category
        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by author
        if ($request->filled('author')) {
            $query->where('created_by', $request->author);
        }

        // Filter by date range
        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%")
                  ->orWhere('content', 'like', "%{$search}%");
            });
        }

        $procedures = $query->latest()->paginate(15);
        $categories = Category::active()->orderBy('order')->get();
        $authors = User::whereHas('procedures')->get();

        return view('procedures.index', compact('procedures', 'categories', 'authors'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Allow all authenticated users to create procedures
        $categories = Category::active()->orderBy('order')->get();
        return view('procedures.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'content' => 'required|string',
            'priority' => 'nullable|integer|min:0|max:2',
            'attachments' => 'nullable|array',
            'attachments.*' => 'file|max:10240|mimes:pdf,doc,docx,jpg,jpeg,png,gif,mp4,avi',
            'checklist_items' => 'nullable|array',
            'checklist_items.*.item' => 'required|string|max:255',
            'checklist_items.*.description' => 'nullable|string',
            'checklist_items.*.is_required' => 'nullable|boolean',
        ]);

        $validated['slug'] = Str::slug($validated['title']);
        $validated['created_by'] = Auth::id();
        
        // Set status based on submit_for_approval checkbox
        if ($request->has('submit_for_approval')) {
            $validated['status'] = 'pending';
        } else {
            $validated['status'] = 'draft';
        }
        
        $validated['version'] = 1;

        $procedure = Procedure::create($validated);

        // Notify managers about new procedure pending approval
        if ($procedure->status === 'pending') {
            $managers = User::whereIn('role', ['super_admin', 'manager'])->get();
            foreach ($managers as $manager) {
                $manager->notify(new ProcedureApprovalNotification($procedure));
            }
        }

        // Handle file uploads
        if ($request->hasFile('attachments')) {
            foreach ($request->file('attachments') as $index => $file) {
                $path = $file->store('procedures', 'public');
                $fileType = $this->getFileType($file->getMimeType());
                
                ProcedureAttachment::create([
                    'procedure_id' => $procedure->id,
                    'file_name' => $file->getClientOriginalName(),
                    'file_path' => $path,
                    'file_type' => $fileType,
                    'file_size' => $file->getSize(),
                    'mime_type' => $file->getMimeType(),
                    'order' => $index,
                ]);
            }
        }

        // Handle checklist items
        if ($request->has('checklist_items')) {
            foreach ($request->checklist_items as $index => $item) {
                if (!empty($item['item'])) {
                    ProcedureChecklist::create([
                        'procedure_id' => $procedure->id,
                        'item' => $item['item'],
                        'description' => $item['description'] ?? null,
                        'is_required' => $item['is_required'] ?? true,
                        'order' => $index,
                    ]);
                }
            }
        }

        return redirect()->route('procedures.show', $procedure)
            ->with('success', 'Procédure créée avec succès.');
    }

    /**
     * Get file type from mime type.
     */
    private function getFileType($mimeType)
    {
        if (str_starts_with($mimeType, 'image/')) {
            return 'image';
        } elseif (str_starts_with($mimeType, 'video/')) {
            return 'video';
        } elseif ($mimeType === 'application/pdf') {
            return 'pdf';
        } else {
            return 'document';
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Procedure $procedure)
    {
        // Increment views count
        $procedure->increment('views_count');
        $procedure->load(['category', 'creator', 'approver', 'attachments', 'checklists', 'versions']);
        
        return view('procedures.show', compact('procedure'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Procedure $procedure)
    {
        $categories = Category::active()->orderBy('order')->get();
        return view('procedures.edit', compact('procedure', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Procedure $procedure)
    {
        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'content' => 'required|string',
            'priority' => 'nullable|integer|min:0|max:2',
            'attachments' => 'nullable|array',
            'attachments.*' => 'file|max:10240|mimes:pdf,doc,docx,jpg,jpeg,png,gif,mp4,avi',
            'checklist_items' => 'nullable|array',
            'checklist_items.*.item' => 'required|string|max:255',
            'checklist_items.*.description' => 'nullable|string',
            'checklist_items.*.is_required' => 'nullable|boolean',
        ]);

        // Create new version if content changed
        if ($procedure->content !== $validated['content']) {
            $procedure->versions()->create([
                'version_number' => $procedure->version,
                'content' => $procedure->content,
                'change_summary' => $request->change_summary,
                'created_by' => Auth::id(),
            ]);
            
            $validated['version'] = $procedure->version + 1;
            $validated['status'] = 'draft'; // Reset to draft when updated
        }

        $validated['slug'] = Str::slug($validated['title']);
        $procedure->update($validated);

        // Handle new file uploads
        if ($request->hasFile('attachments')) {
            $maxOrder = $procedure->attachments()->max('order') ?? -1;
            foreach ($request->file('attachments') as $index => $file) {
                $path = $file->store('procedures', 'public');
                $fileType = $this->getFileType($file->getMimeType());
                
                ProcedureAttachment::create([
                    'procedure_id' => $procedure->id,
                    'file_name' => $file->getClientOriginalName(),
                    'file_path' => $path,
                    'file_type' => $fileType,
                    'file_size' => $file->getSize(),
                    'mime_type' => $file->getMimeType(),
                    'order' => $maxOrder + $index + 1,
                ]);
            }
        }

        // Update checklist items
        if ($request->has('checklist_items')) {
            // Delete existing checklist items
            $procedure->checklists()->delete();
            
            // Create new checklist items
            foreach ($request->checklist_items as $index => $item) {
                if (!empty($item['item'])) {
                    ProcedureChecklist::create([
                        'procedure_id' => $procedure->id,
                        'item' => $item['item'],
                        'description' => $item['description'] ?? null,
                        'is_required' => $item['is_required'] ?? true,
                        'order' => $index,
                    ]);
                }
            }
        }

        return redirect()->route('procedures.show', $procedure)
            ->with('success', 'Procédure mise à jour avec succès.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Procedure $procedure)
    {
        $procedure->delete();
        return redirect()->route('procedures.index')
            ->with('success', 'Procédure supprimée avec succès.');
    }

    /**
     * Approve a procedure.
     */
    public function approve(Procedure $procedure)
    {
        if (!Auth::user()->canApprove()) {
            abort(403, 'Vous n\'avez pas la permission d\'approuver des procédures.');
        }

        $procedure->update([
            'status' => 'approved',
            'approved_by' => Auth::id(),
            'approved_at' => now(),
        ]);

        // Notify creator about approval
        if ($procedure->creator_id !== Auth::id()) {
            $procedure->creator->notify(new NewProcedureNotification($procedure));
        }
        
        // Notify all users about newly approved procedure
        User::where('id', '!=', Auth::id())
            ->where('id', '!=', $procedure->creator_id)
            ->each(function ($user) use ($procedure) {
                $user->notify(new NewProcedureNotification($procedure));
            });

        return redirect()->back()
            ->with('success', 'Procédure approuvée avec succès.');
    }

    /**
     * Delete an attachment.
     */
    public function deleteAttachment(Procedure $procedure, ProcedureAttachment $attachment)
    {
        if ($attachment->procedure_id !== $procedure->id) {
            abort(404);
        }

        Storage::disk('public')->delete($attachment->file_path);
        $attachment->delete();

        return redirect()->back()
            ->with('success', 'Pièce jointe supprimée avec succès.');
    }

    /**
     * Show procedure versions.
     */
    public function versions(Procedure $procedure)
    {
        $procedure->load('versions.creator');
        return view('procedures.versions', compact('procedure'));
    }

    /**
     * Compare two versions.
     */
    public function compareVersions(Procedure $procedure, $version1, $version2)
    {
        $v1 = $procedure->versions()->where('version_number', $version1)->firstOrFail();
        $v2 = $procedure->versions()->where('version_number', $version2)->firstOrFail();
        
        return view('procedures.compare', compact('procedure', 'v1', 'v2'));
    }

    /**
     * Export procedure to PDF.
     */
    public function export(Procedure $procedure)
    {
        $procedure->load(['category', 'creator', 'approver', 'attachments', 'checklists']);
        
        // For now, return a simple HTML view that can be printed as PDF
        // In production, you would use a library like dompdf or barryvdh/laravel-dompdf
        return view('procedures.export', compact('procedure'));
    }
}
