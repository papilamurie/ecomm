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
        Schema::table('users', function (Blueprint $table) {
            $table->string('user_type')->default('Customer')->after('password')->comment('Customer|Vendor');
            $table->tinyInteger('status')->unsigned()->default(1)->after('user_type')->comment('1 = active, 0 = inactive');
            $table->string('address_line1')->nullable()->after('status');
            $table->string('address_line2')->nullable()->after('address_line1');
            $table->string('city')->nullable()->after('address_line2');
            $table->string('county')->nullable()->after('city');
            $table->string('postcode', 20)->nullable()->after('county');
            $table->string('country')->default('United Kingdom')->after('postcode');
            $table->string('phone', 20)->nullable()->after('country');
            $table->string('company')->nullable()->after('phone');
            $table->boolean('is_admin')->default(false)->after('company')->comment('Flag for admin users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'user_type',
                'status',
                'address_line1',
                'address_line2',
                'city',
                'county',
                'postcode',
                'country',
                'phone',
                'company',
                'is_admin'
            ]);
        });
    }
};
