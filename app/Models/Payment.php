<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'abonent_id', 'service_id', 'author_id', 'title', 'value'
    ];

	public $timestamps = false;

    public function author() {
        return $this->hasOne(User::class, 'id', 'author_id');
    }


}
