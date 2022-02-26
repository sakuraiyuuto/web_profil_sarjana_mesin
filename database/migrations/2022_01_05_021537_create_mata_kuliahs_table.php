<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateMataKuliahsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mata_kuliahs', function (Blueprint $table) {
            $table->id();
            $table->string('kode', 100)->nullable(false);
            $table->string('nama', 255)->nullable(false);
            $table->integer('sks')->nullable(false);
            $table->integer('semester')->nullable(false);
            $table->string('kelompok', 100)->nullable(false);
            $table->softDeletes();
            $table->timestamps();
        });

        DB::table('mata_kuliahs')->insert(
            array(
                [
                    'kode' => 'UMG-11111-111',
                    'nama'  => 'Mata Kuliah 1',
                    'sks'  => '1',
                    'semester'  => '2',
                    'kelompok'  => 'Wajib',
                ],
                [
                    'kode' => 'UMG-22222-222',
                    'nama'  => 'Mata Kuliah 2',
                    'sks'  => '3',
                    'semester'  => '4',
                    'kelompok'  => 'Pilihan',
                ],
                [
                    'kode' => 'UMG-33333-333',
                    'nama'  => 'Mata Kuliah 3',
                    'sks'  => '5',
                    'semester'  => '6',
                    'kelompok'  => 'Paket',
                ]
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
        Schema::dropIfExists('mata_kuliahs');
    }
}
