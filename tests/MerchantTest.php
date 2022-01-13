<?php

use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Auth;
use App\Model\User;
use App\Model\Merchant;

class MerchantTest extends TestCase
{
    use DatabaseTransactions;

    public function testExpectSuccesGetMerchantOmzet(){
        
        $user = User::find(1)->first();
        $token = Auth::login($user);

        $this->get("merchants/1/omzet?from=2021-01-01&to=2021-11-30&page=1&per_page=5");
        $this->seeStatusCode(200);

    }

    public function testExpectMerchantNotFound(){
        
        $user = User::find(1);
        $token = Auth::login($user);

        $this->get("merchants/".$user->Merchant()->first()->merchant_name."/omzet?from=2021-01-01&to=2021-11-30&page=1&per_page=5");
        $this->seeStatusCode(400);
        
    }

    public function testExpectUnauthorizedMerchnatOmzet(){
        
        $user = User::find(1)->first();
        $token = Auth::login($user);

        $this->get("merchants/2/omzet?from=2021-01-01&to=2021-11-30&page=1&per_page=5");
        $this->seeStatusCode(401);
        
    }


    public function testExpectSuccesGetOutletOmzet(){
        
        $user = User::find(1)->first();
        $token = Auth::login($user);

        $merchant = $user->Merchant()->first();
        $outlet = $merchant->Outlet()->first();

        $this->get("merchants/".$merchant->id."/outlets/".$outlet->id."/omzet?from=2021-01-01&to=2021-11-30&page=1&per_page=5");
        $this->seeStatusCode(200);

    }


     public function testExpectOutletNotFound(){
        
        $user = User::find(1)->first();
        $token = Auth::login($user);

        $merchant = $user->Merchant()->first();
        $outlet = $merchant->Outlet()->first();

        $this->get("merchants/".$merchant->id."/outlets/999/omzet?from=2021-01-01&to=2021-11-30&page=1&per_page=5");
        $this->seeStatusCode(400);

    }

    public function testExpectUnauthorizedOutletOmzet(){
        
        $user = User::find(1)->first();
        $token = Auth::login($user);

        $merchant = $user->Merchant()->first();
        $outlet = $merchant->Outlet()->first();

        $this->get("merchants/".$merchant->id."/outlets/2/omzet?from=2021-01-01&to=2021-11-30&page=1&per_page=5");
        $this->seeStatusCode(401);
        
    }


   
}
