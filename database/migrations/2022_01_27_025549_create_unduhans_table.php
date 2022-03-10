<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateUnduhansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('unduhans', function (Blueprint $table) {
            $table->id();
            $table->string('judul', 255)->nullable(false);
            $table->string('nama_file', 255)->nullable(false);
            $table->text('slug')->nullable(false);
            $table->date('release_date', 255)->nullable(false);
            $table->softDeletes();
            $table->timestamps();
        });

        DB::table('unduhans')->insert(
            array(
                [
                    'judul' => "Dokumen 1",
                    'nama_file' => "files/unduhan/1.pdf",
                    'slug' => "unduhan/dokumen_1",
                    'release_date' => "2022-01-20",
                ],
                [
                    'judul' => "Dokumen 2",
                    'nama_file' => "files/unduhan/2.pdf",
                    'slug' => "unduhan/dokumen_2",
                    'release_date' => "2022-01-12",
                ],
                [
                    'judul' => "Dokumen 3",
                    'nama_file' => "files/unduhan/3.pdf",
                    'slug' => "unduhan/dokumen_3",
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
        Schema::dropIfExists('unduhans');
    }
}
