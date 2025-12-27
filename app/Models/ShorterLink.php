<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ShorterLink extends Model
{
    protected $table = 'shorter_links';
    protected $guarded = [];
    public $timestamps = true;

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id');
    }
}
