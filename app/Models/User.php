<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'uid',
        'nid',
        'division',
        'district',
        'upazila',
        'country',
        'city',
        'ward',
        'area',
        'mobile',
        'password',
        'sponsor_id',
        'profilePic',
        'role'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        // 'email_verified_at' => 'datetime',
    ];



    public function sponsored_by()
    {
        return $this->belongsTo(User::class, 'sponsor_id')
            ->select(array('id', 'name'));
    }


    public function transaction()
    {
        return $this->hasMany(Transaction::class, 'customer_id', 'id');
    }
}