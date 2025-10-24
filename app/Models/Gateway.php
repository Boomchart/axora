<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Gateway extends Model
{
	use SoftDeletes;

	protected $table = 'gateways';
	protected $fillable = array('name', 'minamo', 'maxamo', 'fixed_charge', 'percent_charge', 'rate', 'val1', 'val2', 'status', 'instructions', 'crypto', 'type', 'receipt', 'image');
}
