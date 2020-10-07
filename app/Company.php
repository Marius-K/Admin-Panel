<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'name', 'email', 'website', 'logo'
    ];

    public function employees()
    {
        return $this->hasMany('App\Employee');
    }
}
