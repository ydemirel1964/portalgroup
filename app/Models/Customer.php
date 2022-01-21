<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model{
    protected $table = 'customer';
    protected $fillable = ['company_id','tc','name','surname','birthyear'];
    public function companies()
    {
        return $this->belongsTo(Company::class,"company_id","id");
    }
}
