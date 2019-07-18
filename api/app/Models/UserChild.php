<?php 

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserChild extends Model {

    protected $table = 'users_child';
    protected $primaryKey = 'usc_id';

    const CREATED_AT = 'usc_created_at';
	const UPDATED_AT = 'usc_updated_at';

}
