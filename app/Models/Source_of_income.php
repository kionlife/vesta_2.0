<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Source_of_income extends Model
{
    use HasFactory;



    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'sources_of_income';

    protected $fillable = [
        'name', 'description', 'added_at'
    ];

    public $timestamps = false;


}
