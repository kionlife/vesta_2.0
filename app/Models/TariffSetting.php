<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TariffSetting extends Model
{
    use HasFactory;

    protected $table = 'tariff_settings';

    protected $fillable = [
        'title', 'service_id', 'multiplier'
    ];

    public $timestamps = false;
}
