<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateQuotesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('quotes', function (Blueprint $table) {
            $table->id();
            $table->text('nama_foto')->nullable(false);
            $table->string('teks', 255)->nullable(false);
            $table->string('sumber', 255)->nullable(false);
            $table->date('release_date')->nullable(false);
            $table->softDeletes();
            $table->timestamps();
        });

        DB::table('quotes')->insert(
            array(
                [
                    'nama_foto' => "images/quote/1.jpg",
                    'teks' => "Quotes 1",
                    'sumber' => "Sumber 1",
                    'release_date' => "2022-01-20",
                ],
                [
                    'nama_foto' => "images/quote/2.jpg",
                    'teks' => "Quotes 2",
                    'sumber' => "Sumber 2",
                    'release_date' => "2022-01-15",
                ],
                [
                    'nama_foto' => "images/quote/3.jpg",
                    'teks' => "Quotes 3",
                    'sumber' => "Sumber 3",
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
        Schema::dropIfExists('quotes');
    }
}
