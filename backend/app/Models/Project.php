<?php 

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Project extends Model {
	
    protected $table = 'projects';
    protected $primaryKey = 'pro_id';

    const CREATED_AT = 'pro_created_at';
	const UPDATED_AT = 'pro_updated_at';
}
