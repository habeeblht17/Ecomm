<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Variant;
use Filament\Forms\Form;
use App\Models\Attribute;
use Filament\Tables\Table;
use App\Models\AttributeValue;
use Filament\Resources\Resource;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Repeater;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\VariantResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\VariantResource\RelationManagers;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Section;

class VariantResource extends Resource
{
    protected static ?string $model = Variant::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([

                Group::make()->schema([

                    Section::make('Info')->schema([

                        TextInput::make('sku')
                        ->unique(Variant::class, 'sku', ignoreRecord: true)
                        ->required(),

                        TextInput::make('price')
                        ->numeric()
                        ->required(),

                        TextInput::make('quantity')
                        ->numeric()
                        ->required(),

                        Select::make('stock')->options([
                            'instock' => 'In Stock',
                            'outofstock' => 'Out of Stock',
                        ])
                        ->required()
                        ->searchable()
                        ->preload()
                        ->native(false),
                    ])->columns(2),

                    Section::make()->schema([
                        Repeater::make('attributes')
                        ->label('Attribute')
                        ->relationship()
                        ->schema([

                            Select::make('attribute_id')
                            ->label('Attribute')
                            ->options(Attribute::all()->pluck('name', 'id'))
                            ->reactive()
                            ->required()
                            ->afterStateUpdated(function (callable $set, $state) {
                                $set('attribute_value_id', null); // Reset attribute value when attribute changes
                            })
                            ->searchable()
                            ->preload()
                            ->native(false),

                            Select::make('attribute_value_id')
                            ->label('Attribute Value')
                            ->options(function (callable $get) {
                                $attribute = Attribute::find($get('attribute_id'));
                                if (!$attribute) {
                                    return AttributeValue::all()->pluck('value', 'id'); // Provide a default set if no attribute selected
                                }
                                return $attribute->values()->pluck('value', 'id');
                            })
                            ->required()
                            ->searchable()
                            ->preload()
                            ->native(false),

                        ])->columns(2),
                    ]),

                ])->columnSpanFull(),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([

                TextColumn::make('sku')
                ->sortable()
                ->searchable()
                ->sortable(),

                TextColumn::make('price')
                ->money()
                ->searchable()
                ->sortable(),

                TextColumn::make('quantity')
                ->sortable(),

                TextColumn::make('stock')
                ->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\ViewAction::make(),
                    Tables\Actions\EditAction::make(),
                    Tables\Actions\DeleteAction::make(),
                ]),
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
            'index' => Pages\ListVariants::route('/'),
            'create' => Pages\CreateVariant::route('/create'),
            'edit' => Pages\EditVariant::route('/{record}/edit'),
        ];
    }
}
