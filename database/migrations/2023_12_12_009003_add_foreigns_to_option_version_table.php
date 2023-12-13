<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('option_version', function (Blueprint $table) {
            $table
                ->foreign('version_id')
                ->references('id')
                ->on('versions')
                ->onUpdate('CASCADE')
                ->onDelete('CASCADE');

            $table
                ->foreign('option_id')
                ->references('id')
                ->on('options')
                ->onUpdate('CASCADE')
                ->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('option_version', function (Blueprint $table) {
            $table->dropForeign(['version_id']);
            $table->dropForeign(['option_id']);
        });
    }
};
