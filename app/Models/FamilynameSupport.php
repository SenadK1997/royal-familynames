<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FamilynameSupport extends Model
{
    use HasFactory;
    protected $table = 'user_family_supports';
    protected $fillable = [
        'user_id',
        'familyname_id',
        'support_amount',
    ];

    public function users()
    {
        return $this->belongsToMany(User::class, 'user_family_supports')->withPivot('support_amount');
    }

    public function familyname()
    {
        return $this->belongsToMany(Familyname::class, 'user_family_supports')->withPivot('support_amount');
    }
}
