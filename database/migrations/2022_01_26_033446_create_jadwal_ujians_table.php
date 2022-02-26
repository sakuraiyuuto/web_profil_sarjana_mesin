<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CreateJadwalUjiansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('jadwal_ujians', function (Blueprint $table) {
            $table->id();
            $table->string('tipe_ujian')->nullable(false);
            $table->string('semester')->nullable(false);
            $table->string('tahun_ajaran')->nullable(false);
            $table->text('nama_file')->nullable(false);
            $table->text('slug')->nullable(false);
            $table->date('release_date', 255)->nullable(false);
            $table->softDeletes();
            $table->timestamps();
        });

        DB::table('jadwal_ujians')->insert(
            array(
                [
                    'tipe_ujian' => "Ujian Tengah Semester",
                    'semester' => "Ganjil",
                    'tahun_ajaran' => "2017/2018",
                    'nama_file' => "files/jadwal_ujian/1.pdf",
                    'slug' => "jadwal_ujian/jadwal-ujian-tengah-semester-ganjil-2017-2018",
                    'release_date' => "2022-01-12",
                ],
                [
                    'tipe_ujian' => "Ujian Akhir Semester",
                    'semester' => "Genap",
                    'tahun_ajaran' => "2020/2021",
                    'nama_file' => "files/jadwal_ujian/2.pdf",
                    'slug' => "jadwal_ujian/jadwal-ujian-akhir-semester-genap-2020-2021",
                    'release_date' => "2022-01-12",
                ],
                [
                    'tipe_ujian' => "Ujian Tengah Semester",
                    'semester' => "Genap",
                    'tahun_ajaran' => "2021/2022",
                    'nama_file' => "files/jadwal_ujian/3.pdf",
                    'slug' => "jadwal_ujian/jadwal-ujian-tengah-semester-genap-2021-2022",
                    'release_date' => "2022-01-12",
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
        Schema::dropIfExists('jadwal_ujians');
    }
}
