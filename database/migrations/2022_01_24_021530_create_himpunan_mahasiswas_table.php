<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateHimpunanMahasiswasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('himpunan_mahasiswas', function (Blueprint $table) {
            $table->id();
            $table->string('nama', 255)->nullable(false);
            $table->text('thumbnail')->nullable(false);
            $table->text('teks')->nullable(false);
            $table->text('facebook')->nullable(true);
            $table->text('url_facebook')->nullable(true);
            $table->text('instagram')->nullable(true);
            $table->text('url_instagram')->nullable(true);
            $table->text('youtube')->nullable(true);
            $table->text('url_youtube')->nullable(true);
            $table->text('twitter')->nullable(true);
            $table->text('url_twitter')->nullable(true);
            $table->softDeletes();
            $table->timestamps();
        });

        DB::table('himpunan_mahasiswas')->insert(
            array(
                [
                    'nama' => 'Himpunan Mahasiswa Teknik Mesin',
                    'thumbnail' => 'images/himpunan_mahasiswa/1.jpg',
                    'teks' => "Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Donec quam felis, ultricies nec, pellentesque eu, pretium quis, sem. Nulla consequat massa quis enim. Donec pede justo, fringilla vel, aliquet nec, vulputate eget, arcu. In enim justo, rhoncus ut, imperdiet a, venenatis vitae, justo. Nullam dictum felis eu pede mollis pretium. Integer tincidunt. Cras dapibus. Vivamus elementum semper nisi. Aenean vulputate eleifend tellus. Aenean leo ligula, porttitor eu, consequat vitae, eleifend ac, enim. Aliquam lorem ante, dapibus in, viverra quis, feugiat a, tellus. Phasellus viverra nulla ut metus varius laoreet. Quisque rutrum. Aenean imperdiet. Etiam ultricies nisi vel augue. Curabitur ullamcorper ultricies nisi. Nam eget dui. Etiam rhoncus. Maecenas tempus, tellus eget condimentum rhoncus, sem quam semper libero, sit amet adipiscing sem neque sed ipsum. Nam quam nunc, blandit vel, luctus pulvinar, hendrerit id, lorem. Maecenas nec odio et ante tincidunt tempus. Donec vitae sapien ut libero venenatis faucibus. Nullam quis ante. Etiam sit amet orci eget eros faucibus tincidunt. Duis leo. Sed fringilla mauris sit amet nibh. Donec sodales sagittis magna. Sed consequat, leo eget bibendum sodales, augue velit cursus nunc, quis gravida magna mi a libero. Fusce vulputate eleifend sapien. Vestibulum purus quam, scelerisque ut, mollis sed, nonummy id, metus. Nullam accumsan lorem in dui. Cras ultricies mi eu turpis hendrerit fringilla. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; In ac dui quis mi consectetuer lacinia. Nam pretium turpis",
                    'facebook' => "Himpunan Mahasiswa Mesin",
                    'url_facebook' => "https://www.facebook.com/",
                    'instagram' => "Himpunan Mahasiswa Mesin",
                    'url_instagram' => "https://www.instagram.com/",
                    'youtube' => "Himpunan Mahasiswa Mesin",
                    'url_youtube' => "https://www.youtube.com/",
                    'twitter' => "Himpunan Mahasiswa Mesin",
                    'url_twitter' => "https://www.twitter.com/",
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
        Schema::dropIfExists('himpunan_mahasiswas');
    }
}
