<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
	protected $guarded = [];

	public function provider()
	{
		return $this->belongsTo(Provider::class);
	}

	public function status()
	{
		return $this->belongsTo(Status::class);
	}

	public function currency()
	{
		return $this->belongsTo(Currency::class);
	}

}
