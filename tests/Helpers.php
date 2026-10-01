<?php

use Propello\PackageLearningS\AuditManager;

function saveLog(): void
{
    app(AuditManager::class)->saveBufferedLog();
}
