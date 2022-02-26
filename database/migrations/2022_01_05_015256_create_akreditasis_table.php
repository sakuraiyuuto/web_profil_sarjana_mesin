<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateAkreditasisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('akreditasis', function (Blueprint $table) {
            $table->id();
            $table->string('judul', 255)->nullable(false);
            $table->text('nama_file')->nullable(false);
            $table->date('release_date')->nullable(false);
            $table->softDeletes();
            $table->timestamps();
        });

        DB::table('akreditasis')->insert(
            array(
                [
                    'judul' => 'Akreditasi 1',
                    'nama_file'  => 'files/akreditasi/1.pdf',
                    'release_date' => date("Y-m-d")
                ],
                [
                    'judul' => 'Akreditasi 2',
                    'nama_file'  => 'files/akreditasi/2.pdf',
                    'release_date' => date("Y-m-d")
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
        Schema::dropIfExists('akreditasis');
    }
}
