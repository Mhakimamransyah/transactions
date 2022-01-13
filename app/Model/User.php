<?php 

namespace App\Model;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Laravel\Lumen\Auth\Authorizable;
use Tymon\JWTAuth\Contracts\JWTSubject;
use App\Model\Merchant;

class User extends Model implements AuthenticatableContract, AuthorizableContract, JWTSubject
{
	 use Authenticatable, Authorizable;
	protected $table = 'users'; 
	protected $primaryKey = 'id';
	const CREATED_AT = 'created_at';
	const UPDATED_AT = 'updated_at';
	protected $fillable = [
		'name', 'user_name', 'password','updated_by'
	];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
    	'password',
    	'updated_by',
    	'created_by',
    	'created_at',
    	'updated_at'
    ];

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }

    public function Merchant()
    {
        return $this->hasMany(Merchant::class,'user_id','id');
    }
}