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
Schema::create('m_spps', function (Blueprint $table) {
    $table->id();
    $table->foreignId('tahun_ajaran_id')->constrained();
    $table->foreignId('sekolah_id')->constrained();
    $table->bigInteger('nominal');
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
        Schema::dropIfExists('m_spps');
    }
};
