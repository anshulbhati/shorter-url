<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    protected $table = 'companies';
    protected $guarded = [];
    public $timestamps = true;

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function shorterUrls()
    {
        return $this->hasMany(ShorterLink::class);
    }
}
