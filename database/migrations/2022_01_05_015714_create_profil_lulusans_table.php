<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CreateProfilLulusansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('profil_lulusans', function (Blueprint $table) {
            $table->id();
            $table->string('nama', 255)->nullable(false);
            $table->string('nim', 15)->nullable(false);
            $table->unsignedInteger('angkatan')->nullable(false);
            $table->unsignedInteger('tahun_lulus')->nullable(false);
            $table->softDeletes();
            $table->timestamps();
        });

        DB::table('profil_lulusans')->insert(
            array(
                [
                    'nama' => "Profil Lulusan 1",
                    'nim' => "D1111111111",
                    'angkatan' => "2001",
                    'tahun_lulus' => "2002",
                ],
                [
                    'nama' => "Profil Lulusan 2",
                    'nim' => "D2222222222",
                    'angkatan' => "2003",
                    'tahun_lulus' => "2004",
                ],
                [
                    'nama' => "Profil Lulusan 3",
                    'nim' => "D3333333333",
                    'angkatan' => "2005",
                    'tahun_lulus' => "2006",
                ],
            )
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('profil_lulusans');
    }
}
