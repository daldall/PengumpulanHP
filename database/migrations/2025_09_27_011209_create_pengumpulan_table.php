    <?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('pengumpulan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('kode', 6)->nullable(); // kode 6 huruf, bisa null jika input manual
            $table->enum('status', ['dikumpulkan', 'diambil']);
            $table->enum('metode', ['kode', 'manual']); // ganti 'qr' jadi 'kode'
            $table->timestamp('waktu_input');
            $table->timestamps();

            // Validasi: kombinasi user_id + qrcode_id harus unik (jika qrcode_id tidak null)
            $table->unique(['user_id', 'kode']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('pengumpulan');
    }
};
