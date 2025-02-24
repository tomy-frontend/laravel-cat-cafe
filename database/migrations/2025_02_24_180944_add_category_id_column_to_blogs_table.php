<?php

// マイグレーション履歴の確認コマンド
// sail artisan migrate:status

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
        Schema::table('blogs', function (Blueprint $table) {
            $table->foreignId('category_id')->after('id')->constrained();
            // 外部キー制約にblogs_category_id_foreign(自動命名)が追加される
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('blogs', function (Blueprint $table) {
            $table->dropConstrainedForeignId('category_id');
        });
    }
};
