<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class User extends Model {

    protected $table = 'users';

    const CREATED_AT = 'user_created_at';
    const UPDATED_AT = 'user_updated_at';

}
