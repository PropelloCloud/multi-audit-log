<?php

use Propello\MultiAuditLog\AuditManager;
use Propello\MultiAuditLog\Models\AuditLogEntry;
use Propello\MultiAuditLog\Tests\Fixtures\OrganisationGroupAlert;
use Propello\MultiAuditLog\Tests\Fixtures\OrganisationGroupBrandSetting;

it('records the correct group_name for a configured model', function () {
    OrganisationGroupAlert::create(['organisation_group_id' => 1]);
    saveLog();

    expect(AuditLogEntry::first()->group_name)->toBe('organisation_group');
});

it('reads group_id from the group-level group_id_column', function () {
    OrganisationGroupAlert::create(['organisation_group_id' => 42]);
    saveLog();

    expect(AuditLogEntry::first()->group_id)->toBe('42');
});

it('reads group_id from the model-level group_id_column override', function () {
    OrganisationGroupBrandSetting::create(['group_id' => 7, 'border_radius' => '4px']);
    saveLog();

    expect(AuditLogEntry::first()->group_id)->toBe('7');
});

it('does not record an entry for a model not in any configured group', function () {
    $model = new class extends \Illuminate\Database\Eloquent\Model {};

    app(AuditManager::class)->record($model, 'created');
    saveLog();

    expect(AuditLogEntry::count())->toBe(0);
});
