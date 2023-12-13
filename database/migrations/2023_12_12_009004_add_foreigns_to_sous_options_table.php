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
        Schema::table('sous_options', function (Blueprint $table) {
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
        Schema::table('sous_options', function (Blueprint $table) {
            $table->dropForeign(['option_id']);
        });
    }
};
