<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CreateKalenderAkademiksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kalender_akademiks', function (Blueprint $table) {
            $table->id();
            $table->string('judul', 255)->nullable(false);
            $table->string('nama_file', 255)->nullable(false);
            $table->text('slug')->nullable(false);
            $table->date('release_date')->nullable(false);
            $table->softDeletes();
            $table->timestamps();
        });

        DB::table('kalender_akademiks')->insert(
            array(
                [
                    'judul' => 'Kalender Akademik 1',
                    'nama_file' => 'files/kalender_akademik/1.pdf',
                    'slug' => 'kalender_akademik/' . Str::slug('Kalender Akademik 1') . '_' . time(),
                    'release_date' => date("Y-m-d")
                ],
                [
                    'judul' => 'Kalender Akademik 2',
                    'nama_file' => 'files/kalender_akademik/2.pdf',
                    'slug' => 'kalender_akademik/' . Str::slug('Kalender Akademik 2') . '_' . time(),
                    'release_date' => date("Y-m-d")
                ],
                [
                    'judul' => 'Kalender Akademik 3',
                    'nama_file' => 'files/kalender_akademik/3.pdf',
                    'slug' => 'kalender_akademik/' . Str::slug('Kalender Akademik 3') . '_' . time(),
                    'release_date' => date("Y-m-d")
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
        Schema::dropIfExists('kalender_akademiks');
    }
}
