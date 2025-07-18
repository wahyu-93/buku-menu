<?php

namespace App\Filament\Resources\ProductResource\Pages;

use App\Filament\Resources\ProductResource;
use App\Models\Product;
use App\Models\Subscription;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;
use Illuminate\Support\Facades\Auth;

class ManageProducts extends ManageRecords
{
    protected static string $resource = ProductResource::class;

    protected function getHeaderActions(): array
    {
        

        if(Auth::user()->role === 'admin'){
            return [
                Actions\CreateAction::make(),
            ];
        }

        // cek subsctription
        $subscription = Subscription::where('user_id', Auth::user()->id)
            ->where('end_date', '>',now())
            ->where('is_active', true)
            ->latest()
            ->first();

        // cek jumlah product yang sudah diinput user
        $countProduct = Product::where('user_id', Auth::user()->id)->count();

        return [
            Actions\Action::make('alert')
                ->label('Produk Kamu Melebihi Batas Penggunaan Gratis, Silahkan Berlangganan')
                ->color('danger')
                ->icon('heroicon-s-exclamation-triangle')
                ->visible(!$subscription && $countProduct >= 2),
            Actions\CreateAction::make(),
        ];
    }
}
