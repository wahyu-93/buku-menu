<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    use HasFactory;

    protected $fillable = ['user_id','end_date','is_active'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function subscriptionPayment()
    {
        return $this->hasOne(SubscriptionPayment::class);
    }
}
