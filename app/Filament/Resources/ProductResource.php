<?php

namespace App\Filament\Resources;

use App\Enums\ProductStockEnum;
use App\Enums\ProductTypeEnum;
use Filament\Forms;
use Filament\Tables;
use App\Models\Product;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Builder;
use Filament\Tables\Columns\BooleanColumn;
use App\Filament\Resources\ProductResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\ProductResource\RelationManagers;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;

class ProductResource extends Resource
{
    protected static ?string $model = Product::class;

    protected static ?string $navigationIcon = 'heroicon-o-bolt';

    protected static ?string $navigationLabel = 'Products';

    protected static ?string $navigationGroup = 'Shop';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Group::make()->schema([

                    Section::make()->schema([

                        TextInput::make('name'),
                        TextInput::make('slug'),
                        MarkdownEditor::make('short_description'),
                        MarkdownEditor::make('description'),
                    ])->columns(2),

                ])->columnSpan('full'),


                Group::make()->schema([

                    Section::make('Price & Inventory')->schema([

                        TextInput::make('sku'),
                        TextInput::make('price'),
                        TextInput::make('quantity'),
                        Select::make('stock')->options([
                            'instock' => ProductStockEnum::INSTOCK->value,
                            'outofstock' => ProductStockEnum::OUTOFSTOCK->value,
                        ]),
                        Select::make('type')->options([
                            'deliverable' => ProductTypeEnum::DELIVERABLE->value,
                            'downloadable' => ProductTypeEnum::DOWNLOADABLE->value,
                        ]),
                    ])->columns(2),

                    Section::make('Association')->schema([

                        Select::make('brand_id')
                            ->relationship('brand', 'name')
                    ]),
                ]),

                Group::make()->schema([

                    Section::make('Status')->schema([

                        Toggle::make('is_visible'),
                        Toggle::make('is_featured'),
                        DatePicker::make('published_at'),

                    ]),

                    Section::make('Image')->schema([

                        FileUpload::make('image')
                    ])->collapsible(),

                ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('image'),
                TextColumn::make('brand.name'),
                TextColumn::make('name'),
                IconColumn::make('is_visible')->boolean(),
                TextColumn::make('price'),
                TextColumn::make('quantity'),
                TextColumn::make('published_at'),
                TextColumn::make('type'),
                TextColumn::make('stock'),
            ])
            ->filters([
                //
            ])
            ->actions([
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
            'index' => Pages\ListProducts::route('/'),
            'create' => Pages\CreateProduct::route('/create'),
            'edit' => Pages\EditProduct::route('/{record}/edit'),
        ];
    }
}
