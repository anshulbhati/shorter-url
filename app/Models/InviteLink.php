<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InviteLink extends Model
{
    protected $table = 'invite_links';
    protected $guarded = [];
    public $timestamps = true;

    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id');
    }

    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id');
    }
}
