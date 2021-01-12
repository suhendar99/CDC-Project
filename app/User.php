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
    public function pengurusGudang()
    {
        return $this->belongsTo('App\Models\PengurusGudang','pengurus_gudang_id','id');
    }
    public function getData()
    {
        return static::with('pemasok','pengurusGudang','bank','pelanggan')->where('name',null)->orderBy('id','desc')->get();
    }

    /**
     * User has many StorageIn.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function storageIn()
    {
        // hasMany(RelatedModel, foreignKeyOnRelatedModel = user_id, localKey = id)
        return $this->hasMany('App\Models\StorageIn');
    }

    /**
     * User has many StorageOut.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function storageOut()
    {
        // hasMany(RelatedModel, foreignKeyOnRelatedModel = user_id, localKey = id)
        return $this->hasMany('App\Models\StorageOut');
    }
}
