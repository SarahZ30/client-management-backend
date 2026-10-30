<?php

namespace Modules\ClientManagement\app\Models;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    protected $table = 'clients';
    protected $primaryKey = 'id';

    protected $fillable = [
        'name',
        'email',
        'phone',
        'company',
        'address',
        'no_of_employees',
        'project_budget',
        'service_charge',
        'discount_value',
        'final_project_value'
    ];
}
