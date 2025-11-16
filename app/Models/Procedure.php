<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;
use App\Models\ComplianceRecord;
use App\Models\ProcedureChecklist;

class Procedure extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'category_id',
        'title',
        'slug',
        'description',
        'content',
        'status',
        'version',
        'created_by',
        'approved_by',
        'approved_at',
        'views_count',
        'priority',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'approved_at' => 'datetime',
        'version' => 'integer',
        'views_count' => 'integer',
        'priority' => 'integer',
    ];

    /**
     * Boot the model.
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($procedure) {
            if (empty($procedure->slug)) {
                $procedure->slug = Str::slug($procedure->title);
            }
        });
    }

    /**
     * Get the category that owns the procedure.
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Get the user who created the procedure.
     */
    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Get the user who approved the procedure.
     */
    public function approver(): BelongsTo
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    /**
     * Get the versions for the procedure.
     */
    public function versions(): HasMany
    {
        return $this->hasMany(ProcedureVersion::class);
    }

    /**
     * Get the attachments for the procedure.
     */
    public function attachments(): HasMany
    {
        return $this->hasMany(ProcedureAttachment::class);
    }

    /**
     * Get the checklist items for the procedure.
     */
    public function checklistItems(): HasMany
    {
        return $this->hasMany(ProcedureChecklist::class)->orderBy('order');
    }

    /**
     * Get the checklists for the procedure (alias for checklistItems).
     */
    public function checklists(): HasMany
    {
        return $this->hasMany(ProcedureChecklist::class)->orderBy('order');
    }

    /**
     * Get the compliance records for the procedure.
     */
    public function complianceRecords(): HasMany
    {
        return $this->hasMany(ComplianceRecord::class);
    }

    /**
     * Scope a query to only include active procedures.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope a query to only include approved procedures.
     */
    public function scopeApproved($query)
    {
        return $query->where('status', 'approved');
    }

    /**
     * Scope a query to filter by status.
     */
    public function scopeStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    /**
     * Increment views count.
     */
    public function incrementViews()
    {
        $this->increment('views_count');
    }
}
