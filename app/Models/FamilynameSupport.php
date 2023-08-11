<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FamilynameSupport extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'familyname_id',
        'support_amount',
    ];

    public function users()
    {
        return $this->belongsToMany(User::class, 'familyname_supports')->withPivot('supported_amount');
    }

    public function familyname()
    {
        return $this->belongsToMany(FamilynameSupport::class, 'familyname_supports')->withPivot('support_amount');
    }
}
