<?php

namespace App\Filament\Resources;

use Closure;
use Filament\Forms;
use Filament\Tables;
use App\Models\Order;
use App\Models\Product;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Support\RawJs;
use Filament\Resources\Resource;
use Filament\Forms\Components\Select;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\OrderResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\OrderResource\RelationManagers;
use Filament\Forms\Components\Toggle;

class OrderResource extends Resource
{
    protected static ?string $model = Order::class;

    protected static ?string $navigationIcon = 'heroicon-o-shopping-cart';
    protected static ?string $navigationGroup = 'Rsvp & Item orders';


    public static function form(Form $form): Form
    {
        $product = Product::all();
        $p = [];
        foreach ($product as $ps) {
            $p[$ps->id.'|'.$ps->name . '|' . $ps->price] = '(' . $ps->category . ') ' . $ps->name . ' - IDR ' . number_format($ps->price);
        }

        return $form
            ->schema([
                Select::make('outlet_id')->label('Outlet')->relationship('outlet', 'name')->required()->native(false),
                Select::make('table_id')->label('Table No.')->relationship('outlet_table', 'code')->required()->native(false),
                Select::make('member_id')->label('Member')->relationship('member', 'username')->required()->native(false)->searchable(['username', 'email', 'phone']),

                Select::make('items')->label('Order Items')->options($p)->required()->native(false)->multiple()
                    ->live()->afterStateUpdated(
                        fn ($state, callable $set) => $set(
                            'subtotal',
                            number_format(array_sum(array_map(function ($item) {
                                return explode('|', $item)[2];
                            }, $state)))
                        )
                    ),

                TextInput::make('subtotal')->label('Subtotal')->prefix('IDR')
            ]);
    }

    public static function table(Table $table): Table
{
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('outlet.name'),
                Tables\Columns\TextColumn::make('outlet_table')->getStateUsing(function (Order $record) {
                    return $record->outlet_table->floor . ' Floor | Table No : '.  $record->outlet_table->code;
                }),
                Tables\Columns\TextColumn::make('member.username'),
                Tables\Columns\TextColumn::make('items')->getStateUsing(function (Order $record) {
                    $items = json_decode($record->items);
                    $html  = '';
                    foreach($items as $item) {
                        $price = number_format($item->price);
                        $name = $item->name;
                        $qty = $item->qty;
                        $html.= '<li>(x'.$qty.') ' . $name . ' -  @' . $price . '</li>';
                    }
                    $html.= '';
                    return $html;
                })->html()->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('subtotal')->money('idr')

            ])->searchable()
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
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
            'index' => Pages\ListOrders::route('/'),
            'create' => Pages\CreateOrder::route('/create'),
            'view' => Pages\ViewOrder::route('/{record}'),
            'edit' => Pages\EditOrder::route('/{record}/edit'),
        ];
    }
}
