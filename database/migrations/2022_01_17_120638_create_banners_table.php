<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateBannersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('banners', function (Blueprint $table) {
            $table->id();
            $table->text('nama_foto')->nullable(false);
            $table->text('teks')->nullable(false);
            $table->date('release_date')->nullable(false);
            $table->softDeletes();
            $table->timestamps();
        });

        DB::table('banners')->insert(
            array(
                [
                    'nama_foto' => "images/banner/1.jpg",
                    'teks' => "Teks Pada Banner 1",
                    'release_date' => "2022-01-20",
                ],
                [
                    'nama_foto' => "images/banner/2.jpg",
                    'teks' => "Teks Pada Banner 2",
                    'release_date' => "2022-01-15",
                ],
                [
                    'nama_foto' => "images/banner/3.jpg",
                    'teks' => "Teks Pada Banner 3",
                    'release_date' => "2022-01-20",
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
        Schema::dropIfExists('banners');
    }
}
