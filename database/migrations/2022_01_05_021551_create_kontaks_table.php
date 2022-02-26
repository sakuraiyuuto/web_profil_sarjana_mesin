<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateKontaksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kontaks', function (Blueprint $table) {
            $table->id();
            $table->string('email', 255);
            $table->string('fax', 255);
            $table->string('alamat', 255);
            $table->string('nomor_telepon', 255);
            $table->string('youtube', 255)->nullable(true);
            $table->string('url_youtube', 255)->nullable(true);
            $table->string('twitter', 255)->nullable(true);
            $table->string('url_twitter', 255)->nullable(true);
            $table->string('facebook', 255)->nullable(true);
            $table->string('url_facebook', 255)->nullable(true);
            $table->string('instagram', 255)->nullable(true);
            $table->string('url_instagram', 255)->nullable(true);
            $table->string('whatsapp', 255)->nullable(true);
            $table->softDeletes();
            $table->timestamps();
        });

        DB::table('kontaks')->insert(
            array(
                [
                    'email' => "admin@teknik.untan.ac.id",
                    'fax' => "fax",
                    'alamat' => "Jl. Prof. Hadari Nawawi",
                    'nomor_telepon' => "0812345",
                    'youtube' => "Teknik Untan",
                    'url_youtube' => "https://www.youtube.com/channel/UCvJJRqp9LQWTb1EzyN5tsjg",
                    'twitter' => "FT Untan",
                    'url_twitter' => "https://twitter.com/ft_untan",
                    'facebook' => "Akademik Fakultas Teknik UNTAN",
                    'url_facebook' => "https://www.facebook.com/akademikteknikuntan/",
                    'instagram' => "Teknik Untan",
                    'url_instagram' => "https://www.instagram.com/univtanjungpura/?hl=en",
                    'whatsapp' => "81248225668",
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
        Schema::dropIfExists('kontaks');
    }
}
