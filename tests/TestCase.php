<?php

namespace Propello\PackageLearningS\Tests;

use Orchestra\Testbench\TestCase as Orchestra;
use Propello\PackageLearningS\AuditServiceProvider;
use Propello\PackageLearningS\Tests\Fixtures\OrganisationGroup;
use Propello\PackageLearningS\Tests\Fixtures\OrganisationGroupAlert;
use Propello\PackageLearningS\Tests\Fixtures\OrganisationGroupBrandSetting;

class TestCase extends Orchestra
{
    protected function getPackageProviders($app)
    {
        return [
            AuditServiceProvider::class,
        ];
    }

    public function getEnvironmentSetUp($app)
    {
        config()->set('database.default', 'testing');

        config()->set('multi-audit-log.groups', [
            'organisation_group' => [
                'group_id_column' => 'organisation_group_id',
                'models' => [
                    OrganisationGroup::class,
                    OrganisationGroupAlert::class,
                    OrganisationGroupBrandSetting::class => ['group_id_column' => 'group_id'],
                ],
            ],
        ]);

        OrganisationGroup::createTable();
        OrganisationGroupAlert::createTable();
        OrganisationGroupBrandSetting::createTable();

        foreach (\Illuminate\Support\Facades\File::allFiles(__DIR__ . '/../database/migrations') as $migration) {
            (include $migration->getRealPath())->up();
        }


    }
}
