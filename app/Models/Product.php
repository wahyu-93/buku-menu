<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class Product extends Model
{
    use HasFactory;

    protected $fillable = ['user_id','product_category_id','image','name','description','price','rating','is_popular'];

    protected $casts = ['price' => 'decimal:2'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function productCategory()
    {
        return $this->belongsTo(ProductCategory::class);
    }

    public function transactionDetails()
    {
        return $this->hasMany(TransactionDetail::class);
    }

    public static function boot()
    {
        parent::boot();

        static::creating(function($model){
            if(Auth::user()->role === 'store'){
                $model->user_id = Auth::user()->id;
            };
        });

        
        static::updating(function($model){
            if(Auth::user()->role === 'store'){
                $model->user_id = Auth::user()->id;
            };
        });
    }

    protected static function booted(): void
    {
        static::deleting(function ($product) {
            // Hapus file dari storage
            if ($product->image) {
                Storage::disk('public')->delete($product->image);
            }
        });
    }
}
