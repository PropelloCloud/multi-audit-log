<?php

use Propello\MultiAuditLog\AuditManager;

function saveLog(): void
{
    app(AuditManager::class)->saveBufferedLog();
}
