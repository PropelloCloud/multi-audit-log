# multi-audit-log

A Laravel package that records model lifecycle events (created, updated, deleted) into a grouped audit log. Multiple related models can be merged into a single audit entry per request, giving you a clean, consolidated change history rather than one row per model.

## How it works

Changes are buffered in memory throughout a request and flushed to the database in a single write at the end (via `app()->terminating()`). Models are organised into named **groups** — when multiple models in the same group change in the same request with the same group ID and event type, their changes are merged into one `AuditLogEntry` row.

## Requirements

- PHP 8.4+
- Laravel 11, 12, or 13

## Installation

```bash
composer require propellocloud/multi-audit-log
```

Publish and run the migration:

```bash
php artisan vendor:publish --tag="multi-audit-log-migrations"
php artisan migrate
```

Publish the config file:

```bash
php artisan vendor:publish --tag="multi-audit-log-config"
```

## Configuration

Define your groups in `config/multi-audit-log.php`. Each group has a name, a `group_id_column` that identifies which column to read the group ID from, and a list of models to observe.

```php
return [
    'groups' => [
        'organisation_group' => [
            'group_id_column' => 'organisation_group_id',
            'models' => [
                App\Models\OrganisationGroup::class,
                App\Models\OrganisationGroupAlert::class,
                // Override group_id_column for a specific model:
                App\Models\OrganisationGroupBrandSetting::class => [
                    'group_id_column' => 'group_id',
                ],
            ],
        ],
    ],
];
```

No further setup is required — the service provider automatically registers observers and the end-of-request flush.

## Audit log entry schema

| Column | Type | Description |
|---|---|---|
| `id` | bigint | Primary key |
| `group_name` | string | The group this entry belongs to |
| `group_id` | string\|null | The value of the group ID column on the model |
| `event` | enum | `created`, `updated`, or `deleted` |
| `old_values` | json\|null | Attribute values before the change |
| `new_values` | json\|null | Attribute values after the change |
| `user_id` | bigint\|null | The authenticated user at the time of the event |
| `created_at` | timestamp | When the entry was written |

## Behaviour

**Buffering and merging** — when multiple models in the same group share a `group_id` and event type within a single request, their attribute changes are merged into one entry. For example, creating an `OrganisationGroupAlert` and an `OrganisationGroupBrandSetting` with the same `group_id` in the same request produces one `created` entry.

**Separate entries are produced** when:
- The `group_id` differs between models.
- The event type differs (e.g., one model is updated and another is deleted).

**`updated_at`-only changes are ignored** — touching a model without changing any other attributes writes nothing to the log.

**Type-safe change detection** — booleans are compared as integers and numeric strings are compared as floats, so superficial type differences don't generate spurious entries.

**Models not in any configured group are silently ignored.**

## Manually flushing the buffer

The buffer is flushed automatically at the end of every request. If you need to flush it early (e.g., in a long-running job), you can do so via the facade or the container:

```php
use Propello\MultiAuditLog\Facades\Audit;

Audit::saveBufferedLog();
```

## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for recent changes.

## License

The MIT License (MIT). Please see [LICENSE](LICENSE.md) for details.
