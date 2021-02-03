<?php

/**
 * Generated file
 */

namespace App\Models\Deneme;



/**
 * Class DefSub
 * 
 * @property int $id
 * @property string $sub_def
 * @property \Carbon\Carbon $kayit_zamani
 * @property \Carbon\Carbon $guncelleme_zamani
 * 
 * @property \Illuminate\Database\Eloquent\Collection|\App\Models\Deneme\Subscriptions[] $subscriptions
 *
 * @package App\Models\Deneme
 */
class DefSub extends \Illuminate\Database\Eloquent\Model
{
	protected $table = 'def_sub';
	public $timestamps = false;

	protected $dates = [
		'kayit_zamani',
		'guncelleme_zamani'
	];

	protected $fillable = [
		'sub_def',
		'kayit_zamani',
		'guncelleme_zamani'
	];

	public function subscriptions()
	{
		return $this->hasMany(\App\Models\Deneme\Subscriptions::class, 'sub_id');
	}
}
