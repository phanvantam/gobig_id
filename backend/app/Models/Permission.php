<?php 

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model {

    protected $table = 'permissions';
    protected $primaryKey  = 'per_id';

    const CREATED_AT = 'per_created_at';
	const UPDATED_AT = 'per_updated_at';
}
