<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateKemitraansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kemitraans', function (Blueprint $table) {
            $table->id();
            $table->text('nama_foto')->nullable(false);
            $table->date('release_date')->nullable(false);
            $table->softDeletes();
            $table->timestamps();
        });

        DB::table('kemitraans')->insert(
            array(
                [
                    'nama_foto' => "images/kemitraan/1.jpg",
                    'release_date' => "2022-01-20",
                ],
                [
                    'nama_foto' => "images/kemitraan/2.jpg",
                    'release_date' => "2022-01-15",
                ],
                [
                    'nama_foto' => "images/kemitraan/3.jpg",
                    'release_date' => "2022-01-15",
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
        Schema::dropIfExists('kemitraans');
    }
}
