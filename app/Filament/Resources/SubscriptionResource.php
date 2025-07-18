<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SubscriptionResource\Pages;
use App\Filament\Resources\SubscriptionResource\RelationManagers;
use App\Models\Subscription;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Auth;

class SubscriptionResource extends Resource
{
    protected static ?string $model = Subscription::class;

    protected static ?string $navigationIcon = 'heroicon-o-banknotes';

    public static function canEdit(Model $record): bool
    {
        if(Auth::user()->role === 'admin'){
            return true;
        };
        
        return false;
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('user_id')
                    ->label('Toko')
                    ->options(User::all()->pluck('name','id')->toArray())
                    ->hidden(fn() => Auth::user()->role === 'store')
                    ->required(),
                Forms\Components\Toggle::make('is_active')
                    ->label('Status Keaktifan')
                    ->hidden(fn() => Auth::user()->role === 'store')
                    ->required(),
                Forms\Components\Repeater::make('subscriptionPayment')
                    ->relationship()
                    ->schema([
                        Forms\Components\FileUpload::make('proof')
                            ->label('Bukti Transfer Kirim Ke Rekening 123456789 (BRI) A/N Wahyu Sebesar Rp. 50.000')
                            ->directory('proof')
                            ->required()
                            ->columnSpanFull(),
                        Forms\Components\Select::make('status')
                            ->options([
                                'pending'   => 'Pending',
                                'success'   => 'Success',
                                'failed'    => 'Failed'
                            ])
                            ->label('Status Pembayaran')    
                            ->required()
                            ->columnSpanFull()
                            ->hidden(fn() => Auth::user()->role === 'store')
                    ])
                    ->columnSpanFull()
                    ->addable(false),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user.name')
                    ->label('Toko')
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Tanggal Mulai')
                    ->dateTime(),
                Tables\Columns\TextColumn::make('end_date')
                    ->label('Tanggal Berakhir')
                    ->dateTime(),
                Tables\Columns\IconColumn::make('is_active')
                    ->boolean(),
                Tables\Columns\ImageColumn::make('subscriptionPayment.proof')
                    ->label('Bukti Pembayaran'),
                Tables\Columns\TextColumn::make('subscriptionPayment.status')
                    ->label('Status Pembayaran'),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('deleted_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageSubscriptions::route('/'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        $user = Auth::user();

        if($user->role === 'admin'){
            return parent::getEloquentQuery();
        }

        return parent::getEloquentQuery()->where('user_id', $user->id);
    }
}
