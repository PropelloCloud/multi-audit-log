<?php

namespace Propello\MultiAuditLog\Tests\Fixtures;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class OrganisationGroupAlert extends Model
{
    protected $table = 'organisation_group_alerts';
    protected $guarded = [];
    protected $fillable = ['organisation_group_id', 'only_logged_in', 'start_date', 'end_date'];

    public static function createTable(): void
    {
        Schema::create('organisation_group_alerts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('organisation_group_id')->nullable();
            $table->boolean('only_logged_in')->default(false);
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->timestamps();
        });
    }
}
