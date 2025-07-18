<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProductResource\Pages;
use App\Filament\Resources\ProductResource\RelationManagers;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\Subscription;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Auth;

class ProductResource extends Resource
{
    protected static ?string $model = Product::class;

    protected static ?string $navigationIcon = 'heroicon-o-shopping-bag';

    protected static ?string $label = 'Manajemen Product';

    protected static ?string $navigationGroup = 'Manajemen Menu';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('user_id')
                    ->label('Toko')
                    ->required()
                    ->reactive()
                    ->hidden(fn() => Auth::user()->role === 'store')
                    ->relationship('user','name'),
                Forms\Components\Select::make('product_category_id')
                    ->label('Product kategori')
                    ->required()
                    ->relationship('productCategory', 'name')
                    ->options(function(callable $get){
                        $userId = $get('user_id');

                        if(!$userId){
                            return [];
                        };

                        return ProductCategory::where('user_id', $userId)
                            ->pluck('name','id');
                    })
                    ->hidden(fn() => Auth::user()->role === 'store')
                    ->disabled(fn(callable $get) => $get('user_id') === null),
                Forms\Components\Select::make('product_category_id')
                    ->label('Product kategori')
                    ->required()
                    ->relationship('productCategory', 'name')
                    ->options(function(){
                        return ProductCategory::where('user_id', Auth::user()->id)
                            ->pluck('name','id');
                    })
                    ->hidden(fn() => Auth::user()->role === 'admin'),
                Forms\Components\TextInput::make('name')
                    ->label('Nama Product')
                    ->columnSpanFull()
                    ->required(),
                Forms\Components\FileUpload::make('image')
                    ->label('Foto Product')
                    ->required()
                    ->columnSpanFull()
                    ->disk('public')
                    ->directory('products')
                    ->image()
                    ->imagePreviewHeight('150')
                    ->visibility('public'),
                Forms\Components\Textarea::make('description')
                    ->label('Description Product')
                    ->required()
                    ->columnSpanFull(),
                Forms\Components\TextInput::make('price')
                    ->label('Harga Product')
                    ->required()
                    ->numeric()
                    ->columnSpanFull()
                    ->prefix('Rp'),
                Forms\Components\TextInput::make('rating')
                    ->label('Rating')
                    ->columnSpanFull()
                    ->numeric(),
                Forms\Components\Toggle::make('is_popular')
                    ->label('Product Populer'),
                Forms\Components\Repeater::make('productIngrediens')
                    ->label('Bahan Baku Product')
                    ->relationship('productIngrediens')
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->label('Nama Bahan')
                            ->required(),
                    ])
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user.name')
                    ->label('Toko')
                    ->hidden(fn() => Auth::user()->role === 'store'),
                Tables\Columns\TextColumn::make('productCategory.name')
                    ->label('Product Kategori'),
                Tables\Columns\ImageColumn::make('image')
                    ->label('Foto Product')
                    ->size(50),
                Tables\Columns\TextColumn::make('name')
                    ->label('Nama Product'),
                Tables\Columns\TextColumn::make('price')
                    ->money('IDR')
                    ->label('Harga Product'),
                Tables\Columns\TextColumn::make('rating')
                    ->label('Rating'),
                Tables\Columns\ToggleColumn::make('is_popular')
                    ->label('Priduct Populer'),
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
                Tables\Filters\SelectFilter::make('user')
                    ->relationship('user','name')
                    ->hidden(fn() => Auth::user()->role === 'store'),

                Tables\Filters\SelectFilter::make('product_category_id')
                    ->options(function(){
                        if(Auth::user()->role === 'store'){
                            return productCategory::where('user_id', Auth::user()->id)
                                ->pluck('name','id');
                        };
                    })
                    ->hidden(fn() => Auth::user()->role === 'admin'),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
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
            'index' => Pages\ManageProducts::route('/'),
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

    public static function canCreate(): bool
    {
        if(Auth::user()->role === 'admin'){
            return true;
        }

        // cek subsctription
        $subscription = Subscription::where('user_id', Auth::user()->id)
            ->where('end_date', '>',now())
            ->where('is_active', true)
            ->latest()
            ->first();

        // cek jumlah product yang sudah diinput user
        $countProduct = Product::where('user_id', Auth::user()->id)->count();

        return !($countProduct >=2  && !$subscription);


    }
}
