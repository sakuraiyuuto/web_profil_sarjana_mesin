<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateProfilSingkatsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('profil_singkats', function (Blueprint $table) {
            $table->id();
            $table->text('nama_foto')->nullable(false);
            $table->text('teks')->nullable(false);
            $table->softDeletes();
            $table->timestamps();
        });

        DB::table('profil_singkats')->insert(
            array(
                [
                    'nama_foto' => "images/profil_singkat/1.jpg",
                    'teks' => "Teks 1",
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
        Schema::dropIfExists('profil_singkats');
    }
}
