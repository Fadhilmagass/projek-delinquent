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
        Schema::table('votes', function (Blueprint $table) {
            // 1. Tambahkan kolom 'type' untuk menyimpan 'upvote' atau 'downvote'
            $table->string('type')->after('votable_type');

            // 2. Hapus kolom 'vote' yang lama
            $table->dropColumn('vote');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('votes', function (Blueprint $table) {
            // 1. Tambahkan kembali kolom 'vote'
            $table->tinyInteger('vote')->after('votable_type');

            // 2. Hapus kolom 'type'
            $table->dropColumn('type');
        });
    }
};