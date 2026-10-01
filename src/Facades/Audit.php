<?php

namespace Propello\MultiAuditLog\Facades;

use Illuminate\Support\Facades\Facade;
use Propello\MultiAuditLog\AuditManager;

/**
 * @see \Propello\MultiAuditLog\AuditManager
 */
class Audit extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return AuditManager::class;
    }
}
