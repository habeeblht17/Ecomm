<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Product;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Illuminate\Support\Str;
use App\Enums\ProductTypeEnum;
use App\Enums\ProductStockEnum;
use Filament\Resources\Resource;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Section;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\ImageColumn;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Illuminate\Database\Eloquent\Builder;
use Filament\Tables\Columns\BooleanColumn;
use Filament\Forms\Components\MarkdownEditor;
use App\Filament\Resources\ProductResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\ProductResource\RelationManagers;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;

class ProductResource extends Resource
{
    protected static ?string $model = Product::class;

    protected static ?string $navigationIcon = 'heroicon-o-bolt';

    protected static ?string $navigationLabel = 'Products';

    protected static ?string $navigationGroup = 'Shop';

    protected static ?int $navigationSort = 0;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Group::make()->schema([

                    Section::make()->schema([

                        TextInput::make('name')
                        ->required()
                        ->live(onBlur: true)
                        ->afterStateUpdated(function (string $operation, $state, Forms\Set $set) {

                            if($operation !== 'create') {
                                return;
                            }

                            $set('slug', Str::slug($state));
                        }),

                        TextInput::make('slug')
                        ->disabled()
                        ->dehydrated()
                        ->required()
                        ->unique(Product::class, 'slug', ignoreRecord: true, ),

                        MarkdownEditor::make('description')
                        ->required(),
                        MarkdownEditor::make('short_description'),

                    ])->columns(2),

                ])->columnSpan('full'),


                Group::make()->schema([

                    Section::make('Price & Inventory')->schema([

                        TextInput::make('sku')
                        ->label("SKU (Stock Keeping Unit)")
                        ->unique(Product::class, 'sku', ignoreRecord: true,)
                        ->required(),

                        TextInput::make('price')
                        ->numeric()
                        //->rule('reqex:/^\d{1,6}(\.\d{0,2})?$/')
                        ->required(),

                        TextInput::make('quantity')
                        ->numeric()
                        ->minValue(1)
                        ->required(),

                        Select::make('stock')->options([
                            'instock' => ProductStockEnum::INSTOCK->value,
                            'outofstock' => ProductStockEnum::OUTOFSTOCK->value,
                        ])
                        ->required(),

                        Select::make('type')->options([
                            'deliverable' => ProductTypeEnum::DELIVERABLE->value,
                            'downloadable' => ProductTypeEnum::DOWNLOADABLE->value,
                        ])
                        ->required(),

                    ])->columns(2),

                    Section::make('Association')->schema([

                        Select::make('brand_id')
                            ->relationship('brand', 'name')
                            ->required(),
                    ]),

                ]),

                // Section Status
                Group::make()->schema([

                    Section::make('Status')->schema([

                        Toggle::make('is_visible')
                        ->label('Visibility')
                        ->helperText('Enable or Disable  Product Visibility')
                        ->default(true),

                        Toggle::make('is_featured')
                        ->label('Featured')
                        ->helperText('Enable or Disable  Product Featured Status'),

                        DatePicker::make('published_at')
                        ->label('Availability')
                        ->default(now()),

                    ]),

                    // Section Image
                    Section::make('Image')->schema([

                        FileUpload::make('image')
                        ->directory('products')
                        ->preserveFilenames()
                        ->image()
                        ->imageEditor(),

                    ])->collapsible(),

                ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('image'),

                TextColumn::make('brand.name')
                ->searchable()
                ->sortable()
                ->toggleable(),

                TextColumn::make('name')
                ->searchable()
                ->sortable(),

                TextColumn::make('slug')
                ->searchable()
                ->sortable()
                ->toggleable(),

                TextColumn::make('price')
                ->searchable()
                ->sortable(),

                TextColumn::make('quantity')
                ->toggleable(),

                IconColumn::make('is_visible')
                ->boolean()
                ->label('Visibility')
                ->sortable()
                ->toggleable(),

                TextColumn::make('published_at')
                ->date()
                ->label('Published Date')
                ->sortable()
                ->toggleable(),

                TextColumn::make('type')
                ->toggleable(),

                TextColumn::make('stock')
                ->toggleable(),
            ])

            ->filters([

                TernaryFilter::make('is_visible')
                ->label('Visibility')
                ->boolean()
                ->trueLabel('Only Visible Products')
                ->falseLabel('Only Hidden Products')
                ->native(false),

                SelectFilter::make('brand')
                ->relationship('brand', 'name'),
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
            'index' => Pages\ListProducts::route('/'),
            'create' => Pages\CreateProduct::route('/create'),
            'edit' => Pages\EditProduct::route('/{record}/edit'),
        ];
    }
}
