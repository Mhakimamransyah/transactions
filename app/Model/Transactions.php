<?php 

namespace App\Model;
use Illuminate\Database\Eloquent\Model;

class Transactions extends Model
{
	protected $table = 'transactions'; 
	protected $primaryKey = 'id';
	const CREATED_AT = 'created_at';
	const UPDATED_AT = 'updated_at';
	protected $fillable = [
		'merchant_id', 'outlet_id', 'created_by','updated_by','bill_total'
	];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    // protected $hidden = [
    // 	'updated_by',
    // 	'created_by',
    // 	'created_at',
    // 	'updated_at'
    // ];
}