<?php

namespace App\Http\Controllers;

use App\Models\Procedure;
use App\Models\ComplianceRecord;
use App\Models\ProcedureChecklist;
use App\Models\User;
use App\Notifications\ComplianceAlertNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ComplianceController extends Controller
{
    /**
     * Show compliance tracking for a procedure.
     */
    public function show(Procedure $procedure)
    {
        $procedure->load(['checklists', 'category']);
        $complianceRecords = ComplianceRecord::where('procedure_id', $procedure->id)
            ->with('user')
            ->latest()
            ->paginate(20);
        
        return view('compliance.show', compact('procedure', 'complianceRecords'));
    }

    /**
     * Store compliance record.
     */
    public function store(Request $request, Procedure $procedure)
    {
        $validated = $request->validate([
            'checklist_item_id' => 'nullable|exists:procedure_checklists,id',
            'is_compliant' => 'required|boolean',
            'notes' => 'nullable|string',
        ]);

        $complianceRecord = ComplianceRecord::create([
            'procedure_id' => $procedure->id,
            'user_id' => Auth::id(),
            'checklist_item_id' => $validated['checklist_item_id'],
            'is_compliant' => $validated['is_compliant'],
            'notes' => $validated['notes'],
            'checked_at' => now(),
        ]);

        // Notify managers if non-compliant
        if (!$validated['is_compliant']) {
            $managers = User::whereIn('role', ['super_admin', 'manager'])->get();
            foreach ($managers as $manager) {
                $manager->notify(new ComplianceAlertNotification($complianceRecord));
            }
        }

        return redirect()->back()
            ->with('success', 'Enregistrement de conformité créé avec succès.');
    }

    /**
     * Show compliance dashboard.
     */
    public function index()
    {
        $procedures = Procedure::approved()
            ->with(['category', 'checklists'])
            ->get();
        
        $complianceStats = [
            'total_procedures' => $procedures->count(),
            'total_checks' => ComplianceRecord::count(),
            'compliant' => ComplianceRecord::where('is_compliant', true)->count(),
            'non_compliant' => ComplianceRecord::where('is_compliant', false)->count(),
        ];

        $recentRecords = ComplianceRecord::with(['procedure', 'user', 'checklistItem'])
            ->latest()
            ->take(10)
            ->get();

        return view('compliance.index', compact('procedures', 'complianceStats', 'recentRecords'));
    }
}
