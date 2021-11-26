<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service2Meter extends Model
{
    use HasFactory;

    protected $table = 'service_to_meter';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'abonent_id', 'service_id', 'meter_id'
    ];

    public $timestamps = false;

    public function services()
    {
        $data = $this->belongsTo(Service::class, 'service_id', 'id');
        return $data;
    }
}
