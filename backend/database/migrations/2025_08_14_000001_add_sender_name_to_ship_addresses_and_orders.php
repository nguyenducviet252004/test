<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('ship_addresses', function (Blueprint $table) {
            $table->string('sender_name')->nullable()->after('recipient_name');
        });
        Schema::table('orders', function (Blueprint $table) {
            $table->string('sender_name')->nullable()->after('ship_address_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ship_addresses', function (Blueprint $table) {
            $table->dropColumn('sender_name');
        });
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn('sender_name');
        });
    }
};
