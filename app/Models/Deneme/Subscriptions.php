<?php

/**
 * Generated file
 */

namespace App\Models\Deneme;



/**
 * Class Subscriptions
 * 
 * @property int $u_id
 * @property int $app_id
 * @property int $sub_id
 * @property \Carbon\Carbon $basl_tarih
 * @property \Carbon\Carbon $bitis_tarih
 * @property \Carbon\Carbon $kayit_zamani
 * 
 * @property \App\Models\Deneme\Application $application
 * @property \App\Models\Deneme\SubsDesc $subs_desc
 * @property \App\Models\Deneme\Register $register
 *
 * @package App\Models\Deneme
 */
class Subscriptions extends \Illuminate\Database\Eloquent\Model
{
	protected $table = 'subscriptions';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'u_id' => 'int',
		'app_id' => 'int',
		'sub_id' => 'int'
	];

	protected $dates = [
		'basl_tarih',
		'bitis_tarih',
		'kayit_zamani'
	];

	protected $fillable = [
		'u_id',
		'app_id',
		'sub_id',
		'basl_tarih',
		'bitis_tarih',
		'kayit_zamani'
	];

	public function application()
	{
		return $this->belongsTo(\App\Models\Deneme\Application::class, 'app_id');
	}

	public function subs_desc()
	{
		return $this->belongsTo(\App\Models\Deneme\SubsDesc::class, 'sub_id');
	}

	public function register()
	{
		return $this->belongsTo(\App\Models\Deneme\Register::class, 'u_id');
	}
}
