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

    public function master()
    {
        return $this->belongsTo(
            'App\Models\User', 
            'use_master_id',
            'use_id', 
        );
    }
}
