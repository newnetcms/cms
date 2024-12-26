<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('cms__categories', function (Blueprint $table) {
            $table->string('post_type')->default('post')->after('slug')->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('cms__categories', function (Blueprint $table) {
            $table->dropIndex(['post_type']);
            $table->dropcolumn('post_type');
        });
    }
};
