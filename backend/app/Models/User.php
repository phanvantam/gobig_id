<?php 

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class User extends Model {

    protected $table = 'users';
    protected $primaryKey = 'use_id';

    const CREATED_AT = 'use_created_at';
	const UPDATED_AT = 'use_updated_at';

}
