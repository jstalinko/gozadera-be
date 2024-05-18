<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProductResource\Pages;
use App\Filament\Resources\ProductResource\RelationManagers;
use App\Models\Product;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ProductResource extends Resource
{
    protected static ?string $model = Product::class;

    protected static ?string $navigationIcon = 'fas-shopping-basket';

    protected static ?string $navigationGroup = 'Products';


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Textarea::make('description')
                    ->required()
                    ->columnSpanFull(),
                Forms\Components\TextInput::make('price')
                    ->required()
                    ->numeric()
                    ->prefix('$'),
                Forms\Components\FileUpload::make('image')
                    ->image()
                    ->required(),
                Forms\Components\TextInput::make('stock')
                    ->required()
                    ->numeric()
                    ->default(10),
                Forms\Components\Select::make('category')
                    ->required()
                    ->options([
                        'food' => 'Food',
                        'beverages' => 'Beverages',
                        'alcohol' => 'Alcohol',
                        'redeemable' => 'Redeemable Product'
                    ])->native(false),
            ]);
    }

    public static function table(Table $table): Table
    {
       
        
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('price')
                    ->money('idr')
                    ->sortable(),
                Tables\Columns\ImageColumn::make('image'),
                Tables\Columns\TextColumn::make('stock')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('category'),
                Tables\Columns\BadgeColumn::make('stock')
                    ->colors([
                        'danger' => fn ($record) => $record->stock <= 0,
                        'warning' => fn ($record) => $record->stock < 10,
                        'success' => fn ($record) => $record->stock >= 10,
                    ]),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make()
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->headerActions([
                Tables\Actions\Action::make('Bulk Add Products')
                    ->icon('heroicon-o-plus')
                    ->form([
                        Forms\Components\Select::make('category')
                            ->required()
                            ->options([
                                'food' => 'Food',
                                'beverages' => 'Beverages',
                                'alcohol' => 'Alcohol',
                                'redeemable' => 'Redeemable Product'
                            ])
                            ->native(false),
                        Forms\Components\FileUpload::make('images')
                            ->label('Image Files')
                            ->multiple()
                            ->required()
                            ->helperText('Image filaname format must be "[product_name]_[product_price].jpg" example : "nasi-goreng_15000.jpg"')
                            ->preserveFilenames(),
                    ])->action(function(array $data): void {
                        $images = $data['images'];
                        $category = $data['category'];
                        foreach ($images as $image) {

                            if(!str_contains($image, '_'))
                            {
                                $price = rand(100000,900000);
                                $product = explode('.', $image)[0];
                                $ext = explode('.', $image)[1];
                                $product = str_replace('-', ' ', $product);

                            }else{
                            $price = explode('_', $image)[1];
                            $ext = explode('.', $price)[1];
                            $price = explode('.', $price)[0];
                            $price = (int) $price;
                            $product = explode('_', $image)[0];
                            $product = str_replace('-', ' ', $product);
                            $product = strtoupper($product);
                            }
                            // change image filename
                            $newFileName = sha1($product) . '.'.$ext;
                            @rename(public_path('storage/'.$image), public_path('storage/'.$newFileName ));

                            $productModal = new Product();
                            $productModal->name = $product;
                            $productModal->description = $product;
                            $productModal->price = $price;
                            $productModal->image = $newFileName;
                            $productModal->stock = 100;
                            $productModal->category = $category;
                            $productModal->save();
                            Notification::make()
                                ->title('Product Added')
                                ->body('Product ' . $product . ' has been added')
                                ->success()
                                ->send();
                        
                        }
                      
                        
                    })
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }
    
   
    public static function getPages(): array
    {
        return [
            'index' => Pages\ListProducts::route('/'),
            'create' => Pages\CreateProduct::route('/create'),
            'view' => Pages\ViewProduct::route('/{record}'),
            'edit' => Pages\EditProduct::route('/{record}/edit'),
        ];
    }
}
