<?php

namespace Propello\PackageLearningS\Tests\Fixtures;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class OrganisationGroup extends Model
{
    protected $table = 'organisations_groups';
    protected $guarded = [];
    protected $fillable = ['display_frontend', 'name', 'display_name'];

    public static function createTable(): void
    {
        Schema::create('organisations_groups', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('display_name')->nullable();
            $table->boolean('display_frontend')->default(false);
            $table->timestamps();
        });
    }
}
