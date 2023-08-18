<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserProfilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_profiles', function (Blueprint $table) {
            $table->id();
            $table->string('id_user');
            $table->text('avatar')->nullable();
            $table->string('emailcontact')->nullable();
            $table->string('nickname')->nullable();
            $table->string('address')->nullable();
            $table->string('state')->nullable();
            $table->string('city')->nullable();
            $table->string('zipcode')->nullable();
            $table->text('description')->nullable();
          
            $table->timestamps();

           
        });

 

        $users = \App\Models\User::all();

        foreach ($users as $user) {
            $userProfile = new \App\Models\UserProfile();
            $userProfile->id_user = $user->id_user;
            // Gán các giá trị thông tin bổ sung khác (nếu có)
            $userProfile->save();
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_profiles');
    }
}