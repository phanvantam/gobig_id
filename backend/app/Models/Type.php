<?php 

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Type extends Model {

    protected $table = 'type';
    protected $primaryKey  = 'typ_id';

    protected $fillable = [
        'typ_name',
    ];

    const CREATED_AT = 'typ_created_at';
	const UPDATED_AT = 'typ_updated_at';
}
