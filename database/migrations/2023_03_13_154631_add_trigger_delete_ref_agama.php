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
        DB::unprepared('CREATE TRIGGER delete_agama
        BEFORE DELETE ON ref_agamas
        FOR EACH ROW
        BEGIN
            DECLARE id INT;
            SET id = old.id;
            UPDATE profile_users SET ref_agama_id = null WHERE ref_agama_id = id;
            UPDATE profile_siswas SET ref_agama_id = null WHERE ref_agama_id = id;
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
