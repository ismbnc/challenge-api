<?php

/**
 * Generated file
 */

namespace App\Models\Deneme;



/**
 * Class SubsDesc
 * 
 * @property int $id
 * @property int $app_id
 * @property string $sub_desc
 * @property float $fiyat
 * @property \Carbon\Carbon $kayit_zamani
 * @property \Carbon\Carbon $guncelleme_zamani
 * 
 * @property \Illuminate\Database\Eloquent\Collection|\App\Models\Deneme\Subscriptions[] $subscriptions
 *
 * @package App\Models\Deneme
 */
class SubsDesc extends \Illuminate\Database\Eloquent\Model
{
	protected $table = 'subs_desc';
	public $timestamps = false;

	protected $casts = [
		'app_id' => 'int',
		'fiyat' => 'float'
	];

	protected $dates = [
		'kayit_zamani',
		'guncelleme_zamani'
	];

	protected $fillable = [
		'app_id',
		'sub_desc',
		'fiyat',
		'kayit_zamani',
		'guncelleme_zamani'
	];

	public function subscriptions()
	{
		return $this->hasMany(\App\Models\Deneme\Subscriptions::class, 'sub_id');
	}
}
