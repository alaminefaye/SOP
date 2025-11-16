<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProcedureVersion extends Model
{
    protected $fillable = [
        'procedure_id',
        'version_number',
        'content',
        'change_summary',
        'created_by',
    ];

    /**
     * Get the procedure that owns the version.
     */
    public function procedure(): BelongsTo
    {
        return $this->belongsTo(Procedure::class);
    }

    /**
     * Get the user who created the version.
     */
    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
