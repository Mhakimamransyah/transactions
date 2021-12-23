<?php 

namespace App\Model;
use Illuminate\Database\Eloquent\Model;

class Merchant extends Model
{
	protected $table = 'merchants'; 
	protected $primaryKey = 'id';
	const CREATED_AT = 'created_at';
	const UPDATED_AT = 'updated_at';
	protected $fillable = [
		'user_id', 'merchants_name', 'created_by','updated_by'
	];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
    	'user_id',
    	'updated_by',
    	'created_by',
    	'created_at',
    	'updated_at'
    ];
}