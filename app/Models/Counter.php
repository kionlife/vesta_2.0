<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Counter extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'abonent_id', 'service_id', 'meter_id', 'author_id', 'value'
    ];

	public $timestamps = false;

	public function meter() {
	    return $this->hasMany(Meters::class, 'id', 'meter_id');
    }

	public function author() {
	    return $this->hasOne(User::class, 'id', 'author_id');
    }

    public function service() {
	    return $this->hasMany(Meters::class, 'id', 'meter_id');
    }



}
