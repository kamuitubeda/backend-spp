<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tagihans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('rekening_id')
                    ->constrained()
                    ->onUpdate('cascade')
                    ->onDelete('cascade');
            $table->foreignId('santri_id')
                    ->constrained()
                    ->onUpdate('cascade')
                    ->onDelete('cascade');
            $table->tinyInteger('lunas');
            $table->dateTime('tanggal_pelunasan')->nullable();
            $table->foreignId('pencatat_pelunasan_id')
                    ->nullable()
                    ->constrained('pegawais')
                    ->onUpdate('cascade')
                    ->onDelete('cascade');
            $table->dateTime('tanggal_pengeluaran')->nullable();
            $table->foreignId('pencatat_pengeluaran_id')
                    ->nullable()
                    ->constrained('pegawais')
                    ->onUpdate('cascade')
                    ->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tagihans');
    }
};
