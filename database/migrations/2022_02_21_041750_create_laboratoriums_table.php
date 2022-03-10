
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLaboratoriumsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('laboratoriums', function (Blueprint $table) {
            $table->id();
            $table->string('nama', 255)->nullable(false);
            $table->text('thumbnail')->nullable(false);
            $table->text('teks')->nullable(false);
            $table->text('slug')->nullable(false);
            $table->date('release_date')->nullable(false);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('laboratoriums');
    }
}
