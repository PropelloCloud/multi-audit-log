<?php

namespace Propello\MultiAuditLog\Tests\Fixtures;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class OrganisationGroupBrandSetting extends Model
{
    protected $table = 'organisation_group_brand_settings';
    protected $guarded = [];
    protected $fillable = ['group_id', 'border_radius', 'border_width', 'background_colour'];

    public static function createTable(): void
    {
        Schema::create('organisation_group_brand_settings', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('group_id')->nullable();
            $table->string('border_radius')->nullable();
            $table->string('border_width')->nullable();
            $table->string('background_colour')->nullable();
            $table->timestamps();
        });
    }
}
