<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Company extends Model {   
    
    protected $table = 'company';
    public function customers()
    {
        return $this->hasMany(Customer::class,"company_id","id");
    }
}