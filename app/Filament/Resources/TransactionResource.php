<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TransactionResource\Pages;
use App\Filament\Resources\TransactionResource\RelationManagers;
use App\Models\Product;
use App\Models\Transaction;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Auth;

class TransactionResource extends Resource
{
    protected static ?string $model = Transaction::class;

    protected static ?string $navigationIcon = 'heroicon-o-currency-dollar';

    protected static ?string $label = 'Manajemen Transactions';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('user_id')
                    ->relationship('user','name')
                    ->label('Toko')
                    ->hidden(fn() => Auth::user()->role === 'store'),
                Forms\Components\TextInput::make('code')
                    ->label('Code')
                    ->required()
                    ->default(fn():string => 'TRX-' . mt_rand(10000,99999)),
                Forms\Components\TextInput::make('name')
                    ->label('Nama Customer')
                    ->required(),
                Forms\Components\TextInput::make('table_number')
                    ->label('Nomor Meja')
                    ->required(),
                Forms\Components\Select::make('payment_method')
                    ->label('Metode Pembayaran')
                    ->options([
                        'cash'  => 'Tunai',
                        'midtrans' => 'Midtrans'
                    ])
                    ->required(),
                Forms\Components\Select::make('status')
                    ->label('Status')
                    ->options([
                        'pending'   => 'Tertunda',
                        'success'   => 'Berhasil',
                        'failed'    => 'Gagal'    
                    ])
                    ->required(),
                Forms\Components\Repeater::make('transactionDetails')
                    ->relationship()
                    ->schema([
                        Forms\Components\Select::make('product_id')
                            ->relationship('product','name')
                            ->label('Product')
                            ->options(function(){
                                if(Auth::user()->role === 'admin'){
                                    return Product::all()->mapWithKeys(function($product){
                                        return [$product->id => $product->name . "(Rp " . number_format($product->price) . ")"];
                                    });
                                }

                                return Product::where('user_id', Auth::user()->id)->get()->mapWithKeys(function($product){
                                    return [$product->id => $product->name . "(Rp " . number_format($product->price) . ")"];
                                });

                            })
                            ->required(),
                        Forms\Components\TextInput::make('quantity')
                            ->label('Jumlah')
                            ->required()
                            ->numeric()
                            ->default(1)
                            ->minValue(1),
                        Forms\Components\TextInput::make('note')
                            ->label('Note'),
                    ])
                    ->columnSpanFull()
                    ->live()
                    ->afterStateUpdated(function(Get $get, Set $set){
                        self::updateTotals($get, $set);
                    })
                    ->reorderable(false),
                Forms\Components\TextInput::make('total_price')
                    ->readOnly(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user_id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('code')
                    ->searchable(),
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('table_number')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('payment_method'),
                Tables\Columns\TextColumn::make('total_price')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('status'),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
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
            'index' => Pages\ManageTransactions::route('/'),
        ];
    }

    public static function updateTotals(Get $get, Set $set)
    {
        // mencari product_id dan quantity yang tidak 0, kemudian dijadikan collective
        $selectedProducts = collect($get('transactionDetails'))->filter(fn($item) => !empty($item['product_id'] && !empty($item['quantity'])));
      
        // ambil harga prodcut berdasarkan collective   
        $prices = Product::find($selectedProducts->pluck('product_id'))->pluck('price', 'id');
      
 
        // hitung total harga
        $total = $selectedProducts->reduce(function($total, $product) use ($prices){
            return $total + ($prices[$product['product_id']] * $product['quantity']);
        },0);

        // set nilainya kedalam total_price
        $set('total_price', (string)$total);
    } 
}
