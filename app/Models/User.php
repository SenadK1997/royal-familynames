<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Contracts\Auth\MustVerifyEmail;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'account_id',
        'website_url',
        'instagram_url',
        'linkedin_url',
        'twitter_url',
        'tiktok_url'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];
    public function familynames()
    {
        return $this->belongsToMany(Familyname::class, 'familyname_user')->withPivot('supported_amount');
    }
    // public function getSupportedFamily()
    // {
    //     return $this->belongsToMany(FamilynameSupport::class, 'user_family_supports')->withPivot('support_amount');
    // }
    public function getSupportedFamily()
    {
        return $this->belongsToMany(Familyname::class, 'user_family_supports')
            ->as('support') // Use 'support' alias for the pivot table
            ->withPivot('support_amount');
    }
}