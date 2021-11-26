<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tariff extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'name', 'value', 'service_id', 'city_id'
    ];

    public function service()
    {
        return $this->hasMany(Service::class, 'id', 'service_id');
    }
}
