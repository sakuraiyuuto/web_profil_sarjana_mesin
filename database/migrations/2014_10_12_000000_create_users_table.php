<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable(false);
            $table->string('email')->nullable(false)->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
        });

        DB::table('users')->insert(
            array(
                [
                    'name' => 'Super Admin',
                    'email' => 'admin@teknik.untan.ac.id',
                    'password' => bcrypt("4dm1n"),
                    'remember_token' => Str::random(60)
                ],
                [
                    'name' => 'Faris',
                    'email' => 'faris@teknik.untan.ac.id',
                    'password' => bcrypt("4dm1n"),
                    'remember_token' => Str::random(60)
                ],
                [
                    'name' => 'Rachman',
                    'email' => 'admin@untan.com',
                    'password' => bcrypt("admin"),
                    'remember_token' => Str::random(60)
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
        Schema::dropIfExists('users');
    }
}
