<?php

use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;
use App\Model\User;

class AuthTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * Expects user success in login.
     *
     *
     */
    public function testExpectSuccessLogin()
    {
       // $user = factory(User::class,3)->create();
        $dummy_user = factory(User::class)->create([
          "name" => "M.Hakim Amransyah",
          "user_name" => "mhakim",
          "password" => md5("12345"),
          "created_at" => date('Y-m-d h:m:s'),
          "updated_at" => date('Y-m-d h:m:s'),
          "created_by" => 0,
          "updated_by" => 0,
        ]);
        $this->post("login",['username'=>$dummy_user->user_name,"password"=>"12345"]);
        $this->seeStatusCode(200);
        $this->seeJsonStructure([
            "data",
            "token"
        ]);
        
    }

     /**
     * Expects user failed in login.
     *
     *
     */
    public function testExpectFailedLogin()
    {
        $this->post("login",['username'=>"mhakim,","password"=>"123456"]);
        $this->seeStatusCode(401);
    }
}
