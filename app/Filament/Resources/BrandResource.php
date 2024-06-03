<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Brand;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Illuminate\Support\Str;
use Filament\Resources\Resource;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Section;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Columns\ColorColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Forms\Components\FileUpload;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Components\ColorPicker;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Forms\Components\MarkdownEditor;
use App\Filament\Resources\BrandResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\BrandResource\RelationManagers;

class BrandResource extends Resource
{
    protected static ?string $model = Brand::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = 'Shop';

    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([

                Group::make()->schema([

                    Section::make('Brand Info')->schema([

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
                        ->unique(Brand::class, 'slug', ignoreRecord: true, ),

                        MarkdownEditor::make('description')
                        ->required()
                        ->maxLength(200),

                    ]),
                ]),

                // Section Status
                Group::make()->schema([

                    Section::make('Color')->schema([
                        ColorPicker::make('brand_color')
                        ->label('Brand Color')
                    ]),

                    Section::make('Status')->schema([

                        Toggle::make('is_visible')
                        ->label('Visibility')
                        ->helperText('Enable or Disable  Product Visibility')
                        ->default(true),

                        Toggle::make('is_featured')
                        ->label('Featured')
                        ->helperText('Enable or Disable  Product Featured Status')
                        ->default(false),

                    ]),

                    // Section Image
                    Section::make('Brand Logo')->schema([

                        FileUpload::make('logo')
                        ->directory('brands')
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

                ImageColumn::make('logo'),

                TextColumn::make('name')
                ->searchable()
                ->sortable(),

                TextColumn::make('slug')
                ->searchable()
                ->sortable()
                ->toggleable(),

                ColorColumn::make('brand_color')
                ->searchable()
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


            ])
            ->filters([
                TernaryFilter::make('is_visible')
                ->label('Visibility')
                ->boolean()
                ->trueLabel('Only Visible Brands')
                ->falseLabel('Only Hidden Brands')
                ->native(false),

                TernaryFilter::make('is_featured')
                ->label('Featured')
                ->boolean()
                ->trueLabel('Only Featured Brands')
                ->falseLabel('Only Hidden Brands')
                ->native(false),
            ])
            ->actions([

                ActionGroup::make([
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
            'index' => Pages\ListBrands::route('/'),
            'create' => Pages\CreateBrand::route('/create'),
            'edit' => Pages\EditBrand::route('/{record}/edit'),
        ];
    }
}
