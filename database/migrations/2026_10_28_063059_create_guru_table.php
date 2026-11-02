<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('guru', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->unique()->constrained('user')->cascadeOnDelete();
            $table->string('nip', 20)->unique();
            $table->string('nama');
            $table->string('jenis_kelamin', 1);
            $table->date('tanggal_lahir')->nullable();
            $table->text('alamat')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('guru');
    }
};
