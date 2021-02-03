<?php

/**
 * Generated file
 */

namespace App\Models\Deneme;



/**
 * Class Purchase
 * 
 * @property string $client_token
 * @property string $hash
 * @property int $durum
 * @property \Carbon\Carbon $kayit_zamani
 *
 * @package App\Models\Deneme
 */
class Purchase extends \Illuminate\Database\Eloquent\Model
{
	protected $table = 'purchase';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'durum' => 'int'
	];

	protected $dates = [
		'kayit_zamani'
	];

	protected $hidden = [
		'client_token'
	];

	protected $fillable = [
		'client_token',
		'hash',
		'durum',
		'kayit_zamani'
	];
}
