<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;


class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'phone_number',
        'isVerified',
        'avatar',
        'social_links',
        'identification_number',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];



    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'phone_verified_at' => 'datetime',
    ];
    public function listing () {
        return $this->hasMany( 'App\Models\Listing');
    }
    
    
    public function sparePart () {
        return $this->belongsTo(SparePart::class);
    }

    public function savedSearches()
    {
        return $this->hasMany(SavedSearch::class);
    }



   // Define the relationship with favorite vehicles
    public function favorites()
    {
        return $this->hasMany(Favourites::class);
    }
    
    public function invoice(){

        return $this->hasMany(Invoice::class, 'invoice_id');
    }



    // 

    public function roles(){
        return $this->belongsToMany(Role::class);
    }
    public function getIsSuperAdminAttribute()
    {
        return $this->roles()->where('id', 1)->exists();
       

    }
    
    public function getIsManagerAttribute()
    {
        return $this->roles()->where('id', 5)->exists();
    }
    public function getIsAdminAttribute()
    {
        return $this->roles()->where('id', 2)->exists();
    }
    public function getIsUserAttribute()
   {
       $userIdsToCheck = [1, 2];
            return !$this->roles()->whereIn('id', $userIdsToCheck)->exists();
   }
    public function getIsBusinessAttribute()
    {
        return $this->roles()->where('id', 4)->exists();
    }
    public function setPasswordAttribute($input)
{
    if ($input) {
        $hashedPassword = Hash::make($input);
        $this->attributes['password'] = $hashedPassword;
    }
}
    

}
