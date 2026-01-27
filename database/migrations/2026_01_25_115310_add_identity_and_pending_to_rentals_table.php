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
        Schema::table('rentals', function (Blueprint $table) {

            $table->string('nama')->nullable()->after('book_id');
            $table->string('tempat_lahir')->nullable()->after('nama');
            $table->date('tanggal_lahir')->nullable()->after('tempat_lahir');
            $table->text('alamat')->nullable()->after('tanggal_lahir');

            $table->enum('status', ['pending', 'rented', 'returned'])
                  ->default('pending')
                  ->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('rentals', function (Blueprint $table) {

            $table->dropColumn([
                'nama',
                'tempat_lahir',
                'tanggal_lahir',
                'alamat',
            ]);

            $table->enum('status', ['rented', 'returned'])
                  ->default('rented')
                  ->change();
        });
    }
};
