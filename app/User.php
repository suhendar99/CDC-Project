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
    public function bulky()
    {
        return $this->belongsTo('App\Models\Bulky');
    }
    public function bank()
    {
        return $this->belongsTo('App\Models\Bank');
    }
    public function pembeli()
    {
        return $this->belongsTo('App\Models\Pembeli');
    }
    public function pemasok()
    {
        return $this->belongsTo('App\Models\Pemasok');
    }
    public function piutang()
    {
        return $this->hasMany('App\Models\Piutang');
    }
    public function pengurusGudang()
    {
        return $this->belongsTo('App\Models\PengurusGudang','pengurus_gudang_id','id');
    }
    public function gudang()
    {
        return $this->hasMany('App\Models\Gudang','user_id','id');
    }
    public function pengurus()
    {
        return $this->belongsTo('App\Models\PengurusGudang','pengurus_gudang_id','id')->where('status', 0);
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

    /**
     * Pemesanan has one Kwitansi.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function kwitansi()
    {
        // hasOne(RelatedModel, foreignKeyOnRelatedModel = pemesanan_id, localKey = id)
        return $this->hasOne('App\Models\Kwitansi');
    }
}
