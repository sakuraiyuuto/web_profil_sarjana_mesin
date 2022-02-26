<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;


class CreateDosensTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dosens', function (Blueprint $table) {
            $table->id();
            $table->string('nama', 255)->nullable(false);
            $table->string('nip', 25)->nullable(false);
            $table->string('pangkat_golongan', 100)->nullable(false);
            $table->string('url', 100)->nullable(true);
            $table->unsignedBigInteger('kelompok_keahlian_dosen_id')->nullable(false);
            $table->foreign('kelompok_keahlian_dosen_id')->references('id')->on('kelompok_keahlian_dosens')->onDelete('cascade');
            $table->softDeletes();
            $table->timestamps();
        });

        DB::table('dosens')->insert(
            array(
                [
                    'nama' => 'Nama 1',
                    'nip' => 'NIP111111111111111',
                    'pangkat_golongan' => 'Golongan 1',
                    'url' => 'https://www.google.com/',
                    'kelompok_keahlian_dosen_id' => '1',
                ],
                [
                    'nama' => 'Nama 2',
                    'nip' => 'NIP222222222222222',
                    'pangkat_golongan' => 'Golongan 2',
                    'url' => 'https://www.bing.com/',
                    'kelompok_keahlian_dosen_id' => '2'
                ],
                [
                    'nama' => 'Nama 3',
                    'nip' => 'NIP333333333333333',
                    'pangkat_golongan' => 'Golongan 3',
                    'url' => 'https://www.yahoo.com/',
                    'kelompok_keahlian_dosen_id' => '3'
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
        Schema::dropIfExists('dosens');
    }
}
