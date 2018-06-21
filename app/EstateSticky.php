<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EstateSticky extends Model
{
	protected $table = 'estate_sticky';

    protected $fillable = ['estate_id'];
}
