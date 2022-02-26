<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateKelompokKeahlianDosensTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kelompok_keahlian_dosens', function (Blueprint $table) {
            $table->id();
            $table->text('kelompok_keahlian')->nullable(false);
            $table->softDeletes();
            $table->timestamps();
        });

        DB::table('kelompok_keahlian_dosens')->insert(
            array(
                [
                    'kelompok_keahlian' => "Kelompok 1"
                ],
                [
                    'kelompok_keahlian' => "Kelompok 2"
                ],
                [
                    'kelompok_keahlian' => "Kelompok 3"
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
        Schema::dropIfExists('kelompok_keahlian_dosens');
    }
}
