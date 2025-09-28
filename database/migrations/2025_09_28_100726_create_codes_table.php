<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('codes', function (Blueprint $table) {
            $table->id();
            $table->string('kode')->unique();
            $table->date('tanggal');
            $table->enum('jenis', ['kumpul', 'pengembalian']);
            $table->time('aktif_dari');
            $table->time('aktif_sampai');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('qrcodes');
    }
};
