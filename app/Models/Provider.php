<?php
  
namespace App\Models;
  
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
  
class Provider extends Model
{
    use HasFactory;
  
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
	protected $table = 'providers';
	 
    protected $fillable = [
        'id', 'title'
    ];
	
	public $timestamps = false;
	
	public function service()
    {
        return $this->belongsTo(Service::class, 'id', 'provider_id');
    }
	
}