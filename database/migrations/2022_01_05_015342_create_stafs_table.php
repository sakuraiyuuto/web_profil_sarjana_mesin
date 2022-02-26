<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateStafsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stafs', function (Blueprint $table) {
            $table->id();
            $table->string('nama', 255)->nullable(false);
            $table->string('nip', 25)->nullable(false);
            $table->string('pangkat_golongan', 100)->nullable(false);
            $table->softDeletes();
            $table->timestamps();
        });

        DB::table('stafs')->insert(
            array(
                [
                    'nama' => 'Staf 1',
                    'nip' => 'NIP111111111111111',
                    'pangkat_golongan' => 'Golongan 1'
                ],
                [
                    'nama' => 'Staf 2',
                    'nip' => 'NIP222222222222222',
                    'pangkat_golongan' => 'Golongan 2'
                ],
                [
                    'nama' => 'Staf 3',
                    'nip' => 'NIP333333333333333',
                    'pangkat_golongan' => 'Golongan 3'
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
        Schema::dropIfExists('stafs');
    }
}
