<?php 

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Position extends Model {

	protected $table = 'positions';
	protected $primaryKey = 'pos_id';

	const CREATED_AT = 'pos_created_at';
	const UPDATED_AT = 'pos_updated_at';

	protected $casts = [
		'pos_created_at' => 'datetime:H:i d/m/Y',
		'pos_updated_at' => 'datetime:H:i d/m/Y',
	];
}
