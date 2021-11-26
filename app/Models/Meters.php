<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Meters extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

	protected $table = 'meters';

    protected $fillable = [
        'abonent_id', 'next_check', 'code', 'counter', 'title', 'archived'
    ];

	public $timestamps = false;

	public function services()
    {
        return $this->belongsToMany(Service::class, 'service_to_meter', 'meter_id', 'service_id');
    }

	public function counters()
    {
        return $this->hasMany(Counter::class, 'meter_id', 'id');
    }

}
