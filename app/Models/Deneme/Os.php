<?php

/**
 * Generated file
 */

namespace App\Models\Deneme;



/**
 * Class Os
 * 
 * @property int $id
 * @property string $ad
 * 
 * @property \Illuminate\Database\Eloquent\Collection|\App\Models\Deneme\Register[] $register
 *
 * @package App\Models\Deneme
 */
class Os extends \Illuminate\Database\Eloquent\Model
{
	protected $table = 'os';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'id' => 'int'
	];

	protected $fillable = [
		'id',
		'ad'
	];

	public function register()
	{
		return $this->hasMany(\App\Models\Deneme\Register::class);
	}
}
