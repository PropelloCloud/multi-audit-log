<?php

use Propello\PackageLearningS\Models\AuditLogEntry;
use Propello\PackageLearningS\Tests\Fixtures\OrganisationGroup;

it('records a create event with new values and no old values', function () {
    OrganisationGroup::create(['name' => 'Test Group', 'display_name' => 'Test']);
    saveLog();

    $entry = AuditLogEntry::first();
    expect($entry->event)->toBe('created')
        ->and($entry->new_values)->toMatchArray(['name' => 'Test Group'])
        ->and($entry->old_values)->toBeEmpty();
});

it('records an update event with both old and new values', function () {
    $group = OrganisationGroup::create(['name' => 'Old Name']);
    saveLog();
    AuditLogEntry::truncate();

    $group->update(['name' => 'New Name']);
    saveLog();

    $entry = AuditLogEntry::first();
    expect($entry->event)->toBe('updated')
        ->and($entry->old_values)->toMatchArray(['name' => 'Old Name'])
        ->and($entry->new_values)->toMatchArray(['name' => 'New Name']);
});

it('records a delete event with old values and no new values', function () {
    $group = OrganisationGroup::create(['name' => 'To Delete']);
    saveLog();
    AuditLogEntry::truncate();

    $group->delete();
    saveLog();

    $entry = AuditLogEntry::first();
    expect($entry->event)->toBe('deleted')
        ->and($entry->old_values)->toMatchArray(['name' => 'To Delete'])
        ->and($entry->new_values)->toBeEmpty();
});

it('does not record an entry when only updated_at changes', function () {
    $group = OrganisationGroup::create(['name' => 'Test']);
    saveLog();
    AuditLogEntry::truncate();

    $group->touch();
    saveLog();

    expect(AuditLogEntry::count())->toBe(0);
});
