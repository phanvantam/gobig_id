<?php 

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserPermission extends Model {

	protected $table = 'user_permissions';
	protected $primaryKey = 'usp_id';

	const CREATED_AT = 'usp_created_at';
	const UPDATED_AT = 'usp_updated_at';
	protected $casts = [
		'usp_created_at' => 'datetime:H:i d/m/Y',
  		'usp_updated_at' => 'datetime:H:i d/m/Y',
	];

	public function user()
    {
        return $this->belongsTo(
            'App\Models\User',
            'usp_user_id',
            'use_id'
        );
    }
}
