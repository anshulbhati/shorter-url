<?php

namespace App\Models;
use App\Models\User;
use App\Models\ShorterLink;
use Illuminate\Database\Eloquent\Factories\HasFactory;


use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;
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
