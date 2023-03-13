<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Make Function sisa_pembayaran
        DB::statement('CREATE FUNCTION sisa_pembayaran (user_id INT, tahun_ajaran_id INT)
        RETURNS INT
        BEGIN
            DECLARE total INT;
            SET total = (SELECT m_spps.nominal FROM users INNER JOIN profile_siswas ON profile_siswas.user_id = users.id INNER JOIN m_spps ON m_spps.id = profile_siswas.spp_id WHERE users.id = user_id) * (12 - (SELECT COUNT(t_pembayarans.id) FROM t_pembayarans WHERE t_pembayarans.siswa_id = user_id AND t_pembayarans.tahun_ajaran_id = tahun_ajaran_id));
            RETURN total;
        END');

        // Make Function sudah_dibayar
        DB::statement('CREATE FUNCTION sudah_dibayar (user_id INT, tahun_ajaran_id INT)
        RETURNS INT
        BEGIN
            DECLARE total INT;
            SET total = (SELECT m_spps.nominal FROM users INNER JOIN profile_siswas ON profile_siswas.user_id = users.id INNER JOIN m_spps ON m_spps.id = profile_siswas.spp_id WHERE users.id = user_id) * ((SELECT COUNT(t_pembayarans.id) FROM t_pembayarans WHERE t_pembayarans.siswa_id = user_id AND t_pembayarans.tahun_ajaran_id = tahun_ajaran_id));
            RETURN total;
        END');

        // Make store prosedured
        DB::statement('CREATE PROCEDURE get_siswa_pembayaran(user_id INT, tahun_ajaran_id INT)
        BEGIN
            SELECT profile_siswas.name, profile_siswas.nisn, (SELECT sudah_dibayar(user_id, tahun_ajaran_id)) as sudah_dibayar, (SELECT sisa_pembayaran(user_id, tahun_ajaran_id)) as sisa_pembayaran FROM users INNER JOIN profile_siswas ON profile_siswas.user_id = users.id WHERE users.id = user_id;
        END');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
};
