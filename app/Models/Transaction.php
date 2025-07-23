<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = ['user_id','code','name','table_number','payment_method','total_price','status','no_telp'];

    // public static function boot()
    // {
    //     parent::boot();

    //     static::creating(function($model){
    //         if(Auth::user()->role === 'store'){
    //             $model->user_id = Auth::user()->id;
    //         };
    //     });

        
    //     static::updating(function($model){
    //         if(Auth::user()->role === 'store'){
    //             $model->user_id = Auth::user()->id;
    //         };
    //     });
    // }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function transactionDetails()
    {
        return $this->hasMany(TransactionDetail::class);
    }
}
