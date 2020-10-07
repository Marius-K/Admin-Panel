<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'firstname', 'lastname', 'email', 'phonenumber'
    ];

    public function company()
    {
        return $this->belongsTo('App\Company');
    }
}
