<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateJadwalSeminarHasilsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('jadwal_seminar_hasils', function (Blueprint $table) {
            $table->id();
            $table->string('semester')->nullable(false);
            $table->string('tahun_ajaran')->nullable(false);
            $table->text('nama_file')->nullable(false);
            $table->text('slug')->nullable(false);
            $table->date('release_date', 255)->nullable(false);
            $table->softDeletes();
            $table->timestamps();
        });

        DB::table('jadwal_seminar_hasils')->insert(
            array(
                [
                    'semester' => "Ganjil",
                    'tahun_ajaran' => "2017/2018",
                    'nama_file' => "files/jadwal_seminar_hasil/1.pdf",
                    'slug' => "jadwal_seminar_hasil/jadwal-seminar_hasil-semester-ganjil-2017-2018",
                    'release_date' => "2022-01-12",
                ],
                [
                    'semester' => "Genap",
                    'tahun_ajaran' => "2020/2021",
                    'nama_file' => "files/jadwal_seminar_hasil/2.pdf",
                    'slug' => "jadwal_seminar_hasil/jadwal-seminar_hasil-semester-genap-2020-2021",
                    'release_date' => "2022-01-12",
                ],
                [
                    'semester' => "Ganjil",
                    'tahun_ajaran' => "2023/2024",
                    'nama_file' => "files/jadwal_seminar_hasil/3.pdf",
                    'slug' => "jadwal_seminar_hasil/jadwal-seminar_hasil-semester-ganjil-2023-2024",
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
        Schema::dropIfExists('jadwal_seminar_hasils');
    }
}
