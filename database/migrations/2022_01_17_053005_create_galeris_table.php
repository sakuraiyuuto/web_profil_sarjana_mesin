<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateGalerisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('galeris', function (Blueprint $table) {
            $table->id();
            $table->text('nama_foto')->nullable(false);
            $table->date('release_date')->nullable(false);
            $table->softDeletes();
            $table->timestamps();
        });

        DB::table('galeris')->insert(
            array(
                [
                    'nama_foto' => "images/galeri/1.jpg",
                    'release_date' => "2022-01-20",
                ],
                [
                    'nama_foto' => "images/galeri/2.jpg",
                    'release_date' => "2022-01-15",
                ],
                [
                    'nama_foto' => "images/galeri/3.jpg",
                    'release_date' => "2022-01-15",
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
        Schema::dropIfExists('galeris');
    }
}
