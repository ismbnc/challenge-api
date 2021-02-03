<?php

/**
 * Generated file
 */

namespace App\Models\Deneme;



/**
 * Class Language
 * 
 * @property int $id
 * @property string $ad
 * @property string $kod
 * @property int $durum
 * 
 * @property \Illuminate\Database\Eloquent\Collection|\App\Models\Deneme\Register[] $register
 *
 * @package App\Models\Deneme
 */
class Language extends \Illuminate\Database\Eloquent\Model
{
	protected $table = 'language';
	public $timestamps = false;

	protected $casts = [
		'durum' => 'int'
	];

	protected $fillable = [
		'ad',
		'kod',
		'durum'
	];

	public function register()
	{
		return $this->hasMany(\App\Models\Deneme\Register::class, 'lang_id');
	}
}
