<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CreateAplikasiIntegrasisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('aplikasi_integrasis', function (Blueprint $table) {
            $table->id();
            $table->string('nama', 255)->nullable(false);
            $table->text('thumbnail')->nullable(false);
            $table->string('teks', 255)->nullable(false);
            $table->string('url', 255)->nullable(false);
            $table->date('release_date', 255)->nullable(false);
            $table->softDeletes();
            $table->timestamps();
        });

        DB::table('aplikasi_integrasis')->insert(
            array(
                [
                    'nama' => "Aplikasi Integrasi 1",
                    'thumbnail' => "images/aplikasi_integrasi/1.jpg",
                    'teks' => "Teks 1",
                    'url' => "https://www.google.com",
                    'release_date' => "2022-01-20",
                ],
                [
                    'nama' => "Aplikasi Integrasi 2",
                    'thumbnail' => "images/aplikasi_integrasi/2.jpg",
                    'teks' => "Teks 2",
                    'url' => "https://www.youtube.com",
                    'release_date' => "2022-01-20",
                ],
                [
                    'nama' => "Aplikasi Integrasi 3",
                    'thumbnail' => "images/aplikasi_integrasi/3.jpg",
                    'teks' => "Teks 3",
                    'url' => "https://www.twitter.com",
                    'release_date' => "2022-01-20",
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
        Schema::dropIfExists('aplikasi_integrasis');
    }
}
