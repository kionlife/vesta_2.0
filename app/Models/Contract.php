<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contract extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
	protected $table = 'contracts';

    protected $fillable = [
        'id', 'abonent_id', 'provider_id', 'title', 'date'
    ];

	public $timestamps = false;


}
