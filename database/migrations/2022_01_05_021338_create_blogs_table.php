<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateBlogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('blogs', function (Blueprint $table) {
            $table->id();
            $table->string('nama', 255)->nullable(false);
            $table->text('url')->nullable(false);
            $table->date('release_date', 255)->nullable(true);
            $table->softDeletes();
            $table->timestamps();
        });

        DB::table('blogs')->insert(
            array(
                [
                    'nama' => "Blog 1",
                    'url' => "https://www.youtube.com/",
                    'release_date' => "2022-01-20",
                ],
                [
                    'nama' => "Blog 2",
                    'url' => "https://www.google.com/",
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
        Schema::dropIfExists('blogs');
    }
}
