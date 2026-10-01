<?php

namespace Propello\PackageLearningS\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property string $group_name
 * @property string|null $group_id
 * @property string $event
 * @property array|null $old_values
 * @property array|null $new_values
 * @property int|null $user_id
 */
class AuditLogEntry extends Model
{
    const UPDATED_AT = null;

    protected $table = 'multi_audit_log_entries';

    protected $fillable = [
        'group_name',
        'group_id',
        'event',
        'old_values',
        'new_values',
        'user_id',
    ];

    protected function casts(): array
    {
        return [
            'old_values' => 'array',
            'new_values' => 'array',
        ];
    }
}
