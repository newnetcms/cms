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
        Schema::table('cms__posts', function (Blueprint $table) {
            $table->string('post_type')->default('post')->after('slug')->index()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('cms__posts', function (Blueprint $table) {
            $table->dropIndex(['post_type']);
        });
    }
};
