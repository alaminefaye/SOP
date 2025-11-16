<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ComplianceRecord extends Model
{
    protected $fillable = [
        'procedure_id',
        'user_id',
        'checklist_item_id',
        'is_compliant',
        'notes',
        'checked_at',
    ];

    protected $casts = [
        'is_compliant' => 'boolean',
        'checked_at' => 'datetime',
    ];

    /**
     * Get the procedure.
     */
    public function procedure(): BelongsTo
    {
        return $this->belongsTo(Procedure::class);
    }

    /**
     * Get the user.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the checklist item.
     */
    public function checklistItem(): BelongsTo
    {
        return $this->belongsTo(ProcedureChecklist::class, 'checklist_item_id');
    }
}
