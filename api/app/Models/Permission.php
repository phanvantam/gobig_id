<?php 

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model {

	protected $table = 'permissions';
	protected $primaryKey  = 'per_id';

	const CREATED_AT = 'per_created_at';
	const UPDATED_AT = 'per_updated_at';

	public function project()
	{
		return $this->belongsTo(
			'App\Models\Project', 
			'per_project_id', 
			'pro_id'
		);
	}

	protected $casts = [
		'per_created_at' => 'datetime:H:i d/m/Y',
		'per_updated_at' => 'datetime:H:i d/m/Y',
	];
}
