<?php

use Propello\PackageLearningS\Models\AuditLogEntry;
use Propello\PackageLearningS\Tests\Fixtures\OrganisationGroup;
use Propello\PackageLearningS\Tests\Fixtures\OrganisationGroupAlert;
use Propello\PackageLearningS\Tests\Fixtures\OrganisationGroupBrandSetting;

it('merges changes from multiple models in the same group into one entry', function () {
    OrganisationGroupAlert::create(['organisation_group_id' => 1, 'only_logged_in' => false]);
    OrganisationGroupBrandSetting::create(['group_id' => 1, 'border_radius' => '4px']);
    saveLog();

    expect(AuditLogEntry::count())->toBe(1);
});

it('produces separate entries for the same group when group_id differs', function () {
    OrganisationGroupAlert::create(['organisation_group_id' => 1]);
    OrganisationGroupAlert::create(['organisation_group_id' => 2]);
    saveLog();

    expect(AuditLogEntry::count())->toBe(2);
});

it('produces separate entries for different events on the same group', function () {
    $group = OrganisationGroup::create(['name' => 'Test']);
    saveLog();
    AuditLogEntry::truncate();

    $group->update(['name' => 'Updated']);
    $group->delete();
    saveLog();

    expect(AuditLogEntry::count())->toBe(2);
});
