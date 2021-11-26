<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'name', 'provider_id'
    ];

	public function balance()
    {
        return $this->hasMany(Balance::class);
    }

	public function provider()
    {
        return $this->hasMany(Provider::class, 'id', 'provider_id');
    }

    public function meters()
    {
        return $this->belongsToMany(Meters::class, 'service_to_meter', 'service_id', 'meter_id');
    }

    public function payment()
    {
        return $this->hasMany(Payment::class, 'service_id', 'id');
    }
}
