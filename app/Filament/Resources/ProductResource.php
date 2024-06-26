<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Product;
use App\Models\Variant;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Forms\Form;
use App\Models\Attribute;
use Filament\Tables\Table;
use App\Models\SubCategory;
use Illuminate\Support\Str;
use App\Models\ChildCategory;
use App\Enums\ProductTypeEnum;
use App\Models\AttributeValue;
use App\Enums\ProductStockEnum;
use Filament\Resources\Resource;
use Illuminate\Support\Collection;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Wizard;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\ImageColumn;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Components\Wizard\Step;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Forms\Components\MarkdownEditor;
use App\Filament\Resources\ProductResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\ProductResource\RelationManagers;

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
                Wizard::make([

                    Step::make('Info')->schema([

                        Group::make()->schema([

                            Section::make('Info')->schema([

                                TextInput::make('name')
                                ->required()
                                ->string()
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
                                ->required()
                                ->string()
                                ->columnSpanFull(),

                            ])->columns(2),

                        ])->columnSpanFull(),


                        Group::make()->schema([

                            Section::make()->schema([
                                MarkdownEditor::make('short_description')
                                ->string()
                                ->nullable()
                                ->maxLength(200),

                            ])->columnSpanFull(),

                            // Inventory and Price section
                            Section::make('Price & Inventory')->schema([
                                TextInput::make('sku')
                                ->label("SKU (Stock Keeping Unit)")
                                ->unique(Product::class, 'sku', ignoreRecord: true)
                                ->required(),

                                TextInput::make('price')
                                ->numeric()
                                ->inputMode('decimal')
                                ->required(),


                                TextInput::make('sale_price')
                                ->numeric()
                                ->inputMode('decimal')
                                ->gt('price', true, 'Sale Price must be greater than Price')
                                ->nullable(),

                                TextInput::make('quantity')
                                ->numeric()
                                ->minValue(1)
                                ->required(),

                                TextInput::make('offer_price')
                                ->label('Offer Price')
                                ->numeric()
                                ->inputMode('decimal')
                                ->lt('price', true, 'Offer Price must be less than Price')
                                ->nullable(),

                                DatePicker::make('offer_start_date')
                                ->label('Offer Start Date')
                                ->date()
                                ->placeholder('d/m/y')
                                ->before('offer_end_date', true, 'Offer Start Date must be before Offer End Date')
                                ->native(false)
                                ->nullable(),

                                DatePicker::make('offer_end_date')
                                ->label('Offer End Date')
                                ->date()
                                ->placeholder('d/m/y')
                                ->after('offer_start_date', true, 'Offer End Date must be after Offer Start Date')
                                ->native(false)
                                ->nullable(),

                                Select::make('stock')->options([
                                    'instock' => ProductStockEnum::INSTOCK->value,
                                    'outofstock' => ProductStockEnum::OUTOFSTOCK->value,
                                ])
                                ->required()
                                ->native(false),

                                Select::make('type')->options([
                                    'deliverable' => ProductTypeEnum::DELIVERABLE->value,
                                    'downloadable' => ProductTypeEnum::DOWNLOADABLE->value,
                                ])
                                ->required()
                                ->native(false),

                            ])->columns(2),

                            // Section Image
                            Section::make('Image')->schema([

                                FileUpload::make('image')
                                ->directory('products')
                                ->preserveFilenames()
                                ->maxSize(2048) // 2MB
                                ->required()
                                ->image()
                                ->imageEditor(),

                            ])->collapsible(),

                        ]),

                        Group::make()->schema([

                            // Association section
                            Section::make('Association')->schema([

                                Select::make('brand_id')
                                ->relationship('brand', 'name')
                                ->required()
                                ->searchable()
                                ->preload()
                                ->native(false),

                                Select::make('vendor_id')
                                ->relationship('vendor', 'name')
                                ->required()
                                ->searchable()
                                ->preload()
                                ->native(false),

                                Select::make('category_id')
                                ->relationship('categories', 'name')
                                ->afterStateUpdated(function (Set $set) {
                                    $set('sub_category_id', null);
                                    $set('child_category_id', null);
                                })
                                ->label('Category')
                                ->live()
                                ->required()
                                ->searchable()
                                ->preload()
                                ->native(false),

                                Select::make('sub_category_id')
                                ->options(fn (Get $get): Collection => SubCategory::query()
                                    ->where('category_id', $get('category_id'))
                                    ->pluck('name', 'id'))
                                ->afterStateUpdated(fn (Set $set) => $set('child_category_id', null))
                                ->required()
                                ->label('Sub-Category')
                                ->live()
                                ->searchable()
                                ->preload()
                                ->native(false),

                                Select::make('child_category_id')
                                ->options(fn (Get $get): Collection => ChildCategory::query()
                                    ->where('sub_category_id', $get('sub_category_id'))
                                    ->pluck('name', 'id'))
                                ->required()
                                ->label('Child-Category')
                                ->live()
                                ->searchable()
                                ->preload()
                                ->native(false),

                            ])->columns(2),

                            // Section Status
                            Section::make('Status')->schema([

                                Toggle::make('is_visible')
                                ->label('Visibility')
                                ->helperText('Enable or Disable  Product Visibility')
                                ->default(true),

                                Toggle::make('is_featured')
                                ->label('Featured')
                                ->helperText('Enable or Disable  Product Featured Status')
                                ->default(false),

                                Toggle::make('is_top')
                                ->label('Top Product')
                                ->helperText('Enable or Disable  Top Product')
                                ->default(false),

                                Toggle::make('is_best')
                                ->label('Best Product')
                                ->helperText('Enable or Disable  Best Product')
                                ->default(false),

                                DatePicker::make('published_at')
                                ->label('Availability')
                                ->required()
                                ->default(now())
                                ->native(false)
                                ->columnSpanFull(),

                            ])->columns(2),

                            // SEO (Meta) section
                            Section::make('SEO (Meta)')->schema([

                                TextInput::make('seo_title')
                                ->string()
                                ->nullable()
                                ->maxLength(225),

                                Textarea::make('seo_description')
                                ->string()
                                ->nullable()
                                ->maxLength(200),
                            ]),

                        ]),

                    ])->columns(2),


                    Step::make('Galleries & Variants')->schema([

                        Group::make()->schema([

                            // Section Image
                            Section::make('Image')->schema([

                                Repeater::make('Galleries')
                                ->relationship('galleries')
                                ->schema([

                                    FileUpload::make('image')
                                    ->directory('products/galleries')
                                    ->preserveFilenames()
                                    ->maxSize(2048) // 2MB
                                    ->required()
                                    ->image()
                                    ->imageEditor()
                                    ->label('Gallery Image'),
                                ])
                                ->columns(1)
                                ->label('Product Gallery')
                                ->grid(2),

                            ])->collapsible(),

                        ])->columnSpanFull(),

                        Group::make()->schema([

                            Section::make('Variants')->schema([
                                Repeater::make('variants')
                                ->relationship('variants')
                                ->schema([
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

                                    Repeater::make('attributes')
                                    ->relationship('attributes')
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

                                ])->columns(2),

                            ]),

                        ])->columnSpanFull(),

                    ])->columns(2),

                ])->columnSpanFull(),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('image'),

                TextColumn::make('name')
                ->searchable()
                ->sortable(),

                TextColumn::make('slug')
                ->searchable()
                ->sortable()
                ->toggleable(),

                TextColumn::make('brand.name')
                ->searchable()
                ->sortable()
                ->toggleable(),

                TextColumn::make('vendor.name')
                ->searchable()
                ->sortable()
                ->toggleable(),

                TextColumn::make('category.name')
                ->searchable()
                ->sortable()
                ->toggleable(),

                TextColumn::make('price')
                ->money()
                ->searchable()
                ->sortable(),

                TextColumn::make('quantity')
                ->toggleable(),

                IconColumn::make('is_visible')
                ->boolean()
                ->label('Visibility')
                ->sortable()
                ->toggleable(),

                IconColumn::make('is_featured')
                ->boolean()
                ->label('Featured')
                ->sortable()
                ->toggleable(),

                IconColumn::make('is_top')
                ->boolean()
                ->label('Top Product')
                ->sortable()
                ->toggleable(),

                IconColumn::make('is_best')
                ->boolean()
                ->label('Best Product')
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

                SelectFilter::make('brand')
                ->relationship('brand', 'name')
                ->native(false),

                SelectFilter::make('vendor')
                ->relationship('vendor', 'name')
                ->native(false),

                TernaryFilter::make('is_visible')
                ->label('Visibility')
                ->boolean()
                ->trueLabel('Only Visible Products')
                ->falseLabel('Only Hidden Products')
                ->native(false),

                TernaryFilter::make('is_featured')
                ->label('Featured')
                ->boolean()
                ->trueLabel('Only Featured Products')
                ->falseLabel('Only Unfeatured Products')
                ->native(false),

                TernaryFilter::make('is_top')
                ->label('Top Product')
                ->boolean()
                ->trueLabel('Only Top Products')
                ->falseLabel('Only Hidden Products')
                ->native(false),

                TernaryFilter::make('is_best')
                ->label('Best Product')
                ->boolean()
                ->trueLabel('Only Best Products')
                ->falseLabel('Only Hidden Products')
                ->native(false),

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
