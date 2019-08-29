<?php 

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class User extends Model {

	protected $table = 'users';
	protected $primaryKey = 'use_id';

	const CREATED_AT = 'use_created_at';
	const UPDATED_AT = 'use_updated_at';

    protected $casts = [
        'use_created_at' => 'datetime:H:i d/m/Y',
        'use_updated_at' => 'datetime:H:i d/m/Y',
    ];
    
	public function position()
	{
		return $this->belongsTo(
			'App\Models\Position', 
			'use_position_id',
			'pos_id', 
		);
	}

	public function permission()
    {
        return $this->hasManyThrough(
            'App\Models\Permission',
            'App\Models\UserPermission',
            'usp_user_id', 
            'per_id',
            'use_id',
            'usp_permission_id'
        );
    }
   public function children()
    {
        return $this->hasManyThrough(
            'App\Models\User',
            'App\Models\UserChild',
            'usc_parent_id', 
            'use_id',
            'use_id',
            'usc_child_id'
        );
    }
}
