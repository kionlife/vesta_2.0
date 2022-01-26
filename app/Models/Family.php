<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Family extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'abonent_id', 'first_name', 'second_name', 'last_name', 'archived','updated_at','created_at'
    ];

    public $timestamps = false;

    public function abonent() {
        return $this->hasOne(Abonent::class, 'id', 'abonent_id');
    }


}
