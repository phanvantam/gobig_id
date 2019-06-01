<?php 

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class User extends Model {

    protected $table = 'user';
    protected $primaryKey  = 'use_id';

    protected $fillable = [
        'use_name',
        'use_type',
        'use_mail',
        'use_password',
        'use_token',
    ];

    const CREATED_AT = 'use_created_at';
	const UPDATED_AT = 'use_updated_at';

    public function type()
    {
        return $this->hasOne('App\Models\Type','typ_id','use_type');
    }
}
