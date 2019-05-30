<?php 

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WebhookLog extends Model {

    protected $table = 'webhook_logs';

    const CREATED_AT = 'wel_created_at';
	const UPDATED_AT = 'wel_updated_at';
    // protected $dates = [];

    // public static $rules = [
        // Validation rules
    // ];

    // Relationships

}
