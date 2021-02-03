<?php

/**
 * Generated file
 */

namespace App\Models\Deneme;



/**
 * Class Register
 * 
 * @property int $u_id
 * @property int $app_id
 * @property int $lang_id
 * @property int $os_id
 * @property string $client_token
 * @property int $durum
 * @property \Carbon\Carbon $kayit_zamani
 * @property \Carbon\Carbon $guncelleme_zamani
 * 
 * @property \App\Models\Deneme\Language $language
 * @property \App\Models\Deneme\Os $os
 * @property \Illuminate\Database\Eloquent\Collection|\App\Models\Deneme\Subscriptions[] $subscriptions
 *
 * @package App\Models\Deneme
 */
class Register extends \Illuminate\Database\Eloquent\Model
{
	protected $table = 'register';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'u_id' => 'int',
		'app_id' => 'int',
		'lang_id' => 'int',
		'os_id' => 'int',
		'durum' => 'int'
	];

	protected $dates = [
		'kayit_zamani',
		'guncelleme_zamani'
	];

	protected $hidden = [
		'client_token'
	];

	protected $fillable = [
		'u_id',
		'app_id',
		'lang_id',
		'os_id',
		'client_token',
		'durum',
		'kayit_zamani',
		'guncelleme_zamani'
	];

	public function language()
	{
		return $this->belongsTo(\App\Models\Deneme\Language::class, 'lang_id');
	}

	public function os()
	{
		return $this->belongsTo(\App\Models\Deneme\Os::class);
	}

	public function subscriptions()
	{
		return $this->hasMany(\App\Models\Deneme\Subscriptions::class, 'u_id');
	}
}
