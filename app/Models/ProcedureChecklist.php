<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ProcedureChecklist extends Model
{
    protected $fillable = [
        'procedure_id',
        'item',
        'description',
        'order',
        'is_required',
    ];

    protected $casts = [
        'is_required' => 'boolean',
        'order' => 'integer',
    ];

    /**
     * Get the procedure that owns the checklist item.
     */
    public function procedure(): BelongsTo
    {
        return $this->belongsTo(Procedure::class);
    }

    /**
     * Get the compliance records for this checklist item.
     */
    public function complianceRecords(): HasMany
    {
        return $this->hasMany(ComplianceRecord::class, 'checklist_item_id');
    }
}
