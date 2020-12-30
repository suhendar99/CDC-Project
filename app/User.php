<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements MustVerifyEmail
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function pelanggan()
    {
        return $this->belongsTo('App\Models\Pelanggan');
    }
    public function karyawan()
    {
        return $this->belongsTo('App\Models\Karyawan');
    }
    public function bank()
    {
        return $this->belongsTo('App\Models\Bank');
    }
    public function pemasok()
    {
        return $this->belongsTo('App\Models\Pemasok');
    }
    public function getData()
    {
        return static::with('pemasok','karyawan','bank','pelanggan')->where('name',null)->orderBy('id','desc')->get();
    }
}
