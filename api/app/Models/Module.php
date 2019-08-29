<?php 

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Module extends Model {

	protected $table = 'modules';
	protected $primaryKey  = 'mod_id';

	const CREATED_AT = 'mod_created_at';
	const UPDATED_AT = 'mod_updated_at';

	protected $casts = [
		'mod_created_at' => 'datetime:H:i d/m/Y',
		'mod_updated_at' => 'datetime:H:i d/m/Y',
	];
}
