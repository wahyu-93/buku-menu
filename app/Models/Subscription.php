<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class Subscription extends Model
{
    use HasFactory;

    protected $fillable = ['user_id','end_date','is_active'];

    public static function boot()
    {
        parent::boot();

        static::creating(function($model){
            if(Auth::user()->role === 'store'){
                $model->user_id = Auth::user()->id;
            };

            $model->end_date = now()->addDays(30);
        });
    }

    protected static function booted(): void
    {
        static::deleting(function ($subscription) {
            // Hapus file dari storage
            if ($subscription->subscriptionPayment[0]->proof) {
                Storage::disk('public')->delete($subscription->subscriptionPayment[0]->proof);
            }
        });
    }
        
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function subscriptionPayment()
    {
        return $this->hasMany(SubscriptionPayment::class);
    }
}
