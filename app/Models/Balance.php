<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Balance extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

	protected $table = 'balances';

    protected $fillable = [
        'abonent_id', 'service_id', 'value', 'status'
    ];

	public $timestamps = false;

	public function abonent()
    {
        return $this->belongsTo(Abonent::class, 'id', 'abonent_id');
    }

	public function service()
    {
        return $this->belongsTo(Service::class, 'service_id', 'id');
    }

}
