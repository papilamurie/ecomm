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
    Schema::table('filters', function (Blueprint $table) {
        $table->string('filter_column')->nullable()->after('filter_name');
    });
}

public function down(): void
{
    Schema::table('filters', function (Blueprint $table) {
        $table->dropColumn('filter_column');
    });
}

};
