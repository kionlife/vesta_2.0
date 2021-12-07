<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Abonent extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'personal_account', 'user_id', 'name', 'address', 'phone', 'peoples', 'city_id', 'status', 'archived'
    ];

	public function balance()
    {
        return $this->hasMany(Balance::class);
    }

	public function balanceCalc($service_id)
    {
        $payment = $this->hasMany(Payment::class)->where('service_id', $service_id)->sum('value');
        $cost = $this->hasMany(Cost::class)->where('service_id', $service_id)->sum('value');
        $status = $this->hasMany(Balance::class)->where('service_id', $service_id)->first('status')['status'];
        $val = $payment - $cost;
        return [
            'value' => round($val, 2),
            'status' => $status,
        ];
    }

	public function balanceCalcMass()
    {
        $user = Auth::user();
        $service_id = Inspector2Service::where('user_id', $user->id)->get('service_id');
        $payment = $this->hasMany(Payment::class)->whereIn('service_id', $service_id)->sum('value');
        $cost = $this->hasMany(Cost::class)->whereIn('service_id', $service_id)->sum('value');
        $status = $this->hasMany(Balance::class)->whereIn('service_id', $service_id)->first('status')['status'];
        $val = $payment - $cost;
        return [
            'value' => round($val, 2),
            'status' => $status,
        ];
    }

	public function service()
    {
        return $this->hasMany(Balance::class);
    }

    public function type() {
        return $this->belongsToMany(Type::class, 'abonent_type', 'abonent_id', 'type_id')->withPivot('type_id', 'abonent_id');;
    }

    public function city() {
        return $this->hasOne(City::class, 'id', 'city_id');
    }

    public function receipt() {
        return $this->hasMany(Receipt::class, 'abonent_id', 'id');
    }

    public function counter() {
        return $this->hasMany(Counter::class, 'abonent_id', 'id');
    }

    public function meter() {
        return $this->hasMany(Meters::class, 'abonent_id', 'id');
    }
}
