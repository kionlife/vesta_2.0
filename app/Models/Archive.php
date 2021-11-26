<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Archive extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'archive';

    protected $fillable = [
        'id', 'abonent_id', 'data', 'title'
    ];

    public $timestamps = false;


}
