<?php 

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserPermission extends Model {

    protected $table = 'user_permissions';
    protected $primaryKey = 'usp_id';

    const CREATED_AT = 'usp_created_at';
	const UPDATED_AT = 'usp_updated_at';

}
