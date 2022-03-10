<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJurnalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('jurnals', function (Blueprint $table) {
            $table->id();
            $table->string('judul', 255)->nullable(false);
            $table->string('tahun')->nullable(false);
            $table->text('nomor_volume')->nullable(false);
            $table->text('url')->nullable(false);
            $table->date('release_date', 255)->nullable(false);
            $table->softDeletes();
            $table->timestamps();
        });

        DB::table('jurnals')->insert(
            array(
                [
                    'judul' => "Jurnal 1",
                    'tahun' => "2018",
                    'nomor_volume' => "Vol.2 No. 4, 4 Desember 2019",
                    'url' => "https://ejournal.unesa.ac.id/index.php/jpak/article/view/21294",
                    'release_date' => date("Y-m-d")
                ],
                [
                    'judul' => "Jurnal 2",
                    'tahun' => "2020",
                    'nomor_volume' => "Vol.1 No. 3, 6 Januari 2021",
                    'url' => "https://www.jpa.ub.ac.id/index.php/jpa/article/view/531",
                    'release_date' => date("Y-m-d")
                ],
                [
                    'judul' => "Jurnal 3",
                    'tahun' => "2022",
                    'nomor_volume' => "Vol.3 No. 9, 13 Juli 2023",
                    'url' => "https://www.neliti.com/publications/96826/jurnal-pengaruh-persepsi-harga-dan-promosi-terhadap-keputusan-pembelian-konsumen",
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
        Schema::dropIfExists('jurnals');
    }
}
