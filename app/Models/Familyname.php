<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Familyname extends Model
{
    use HasFactory;

    public function users()
    {
        return $this->belongsToMany(User::class, 'familyname_user')->withPivot('supported_amount');
    }
    public function supporters()
    {
        return $this->belongsToMany(User::class, 'familyname_supports')
            ->withPivot('support_amount');
    }
    protected $fillable = ['family_name', 'flag_url', 'country', 'valuation', 'family_code', 'user_id'];
}
