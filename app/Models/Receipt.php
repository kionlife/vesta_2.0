<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Receipt extends Model
{
    use HasFactory;
    protected $table = 'receipt';

    public function abonent()
    {
        return $this->hasOne(Abonent::class, 'id', 'abonent_id');
    }

    public function author()
    {
        return $this->hasOne(User::class, 'id', 'author_id');
    }

    public function services()
    {
        return $this->hasMany(ReceiptData::class, 'receipt_id', 'id');
    }

    public function service()
    {
        return $this->hasOne(ReceiptData::class, 'id', 'service_id');
    }

    public function status()
    {
        return $this->hasOne(ReceiptStatus::class, 'id', 'status_id');
    }
}
