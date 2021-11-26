<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cost extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $table = 'costs';

    public $timestamps = false;

    protected $fillable = [
        'abonent_id', 'service_id', 'author_id', 'title', 'value', 'created_at'
    ];

    public function author() {
        return $this->hasOne(User::class, 'id', 'author_id');
    }

}
