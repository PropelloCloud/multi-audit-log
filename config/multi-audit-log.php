<?php

// config for Propello/MultiAuditLog
return [

    /*
    |--------------------------------------------------------------------------
    | Audit Groups
    |--------------------------------------------------------------------------
    |
    | Define named groups of models to audit together. Models in the same group
    | with the same group_id and event type will be merged into a single audit
    | log entry per request.
    |
    | Each group requires:
    |   - group_id_column: the column used to identify which group instance
    |                      changed (e.g. a foreign key like organisation_group_id)
    |   - models: an array of Eloquent model class names to observe. A model can
    |             override group_id_column by using the class name as the key and
    |             passing an array with its own group_id_column.
    |
    | Example:
    |
    | 'organisation_group' => [
    |     'group_id_column' => 'organisation_group_id',
    |     'models' => [
    |         App\Models\OrganisationGroup::class,
    |         App\Models\OrganisationGroupAlert::class,
    |         App\Models\OrganisationGroupBrandSetting::class => [
    |             'group_id_column' => 'group_id',
    |         ],
    |     ],
    | ],
    |
    */

    'groups' => [
        '' => [
            'group_id_column' => '',
            'models' => [

            ]
        ]
    ],

];
