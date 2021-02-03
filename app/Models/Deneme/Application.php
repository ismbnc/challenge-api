<?php

/**
 * Generated file
 */

namespace App\Models\Deneme;



/**
 * Class Application
 * 
 * @property int $id
 * @property string $ad
 * 
 * @property \Illuminate\Database\Eloquent\Collection|\App\Models\Deneme\Subscriptions[] $subscriptions
 *
 * @package App\Models\Deneme
 */
class Application extends \Illuminate\Database\Eloquent\Model
{
	protected $table = 'application';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'id' => 'int'
	];

	protected $fillable = [
		'id',
		'ad'
	];

	public function subscriptions()
	{
		return $this->hasMany(\App\Models\Deneme\Subscriptions::class, 'app_id');
	}
}
