<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Illuminate\Support\Str;
use App\Models\ChildCategory;
use Filament\Resources\Resource;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Section;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use Filament\Tables\Filters\TernaryFilter;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\ChildCategoryResource\Pages;
use App\Filament\Resources\ChildCategoryResource\RelationManagers;

class ChildCategoryResource extends Resource
{
    protected static ?string $model = ChildCategory::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = 'Shop';

    protected static ?int $navigationSort = 4;


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
                        ->unique(ChildCategory::class, 'slug', ignoreRecord: true, ),



                    ]),
                ]),

                // Section Status
                Group::make()->schema([

                    Section::make('Status')->schema([

                        Toggle::make('is_visible')
                        ->label('Visibility')
                        ->helperText('Enable or Disable Sub Category Visibility')
                        ->default(true),

                    ]),

                    Section::make('Association')->schema([

                        Select::make('category_id')
                        ->relationship('category', 'name')
                        ->required()
                        ->native(false),

                        Select::make('sub_category_id')
                        ->relationship('subcategory', 'name')
                        ->required()
                        ->native(false),
                    ]),

                ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                ->searchable()
                ->sortable(),

                TextColumn::make('category.name')
                ->searchable()
                ->sortable()
                ->toggleable(),

                TextColumn::make('subcategory.name')
                ->searchable()
                ->sortable()
                ->toggleable(),

                TextColumn::make('slug')
                ->searchable()
                ->sortable()
                ->toggleable(),

                IconColumn::make('is_visible')
                ->boolean()
                ->label('Visibility')
                ->toggleable(),
            ])
            ->filters([
                TernaryFilter::make('is_visible')
                ->label('Visibility')
                ->boolean()
                ->trueLabel('Only Visible Child Categories')
                ->falseLabel('Only Hidden Child Categories')
                ->native(false),

                SelectFilter::make('category')
                ->relationship('category', 'name')
                ->native(false),

                SelectFilter::make('sub_category')
                ->relationship('subcategory', 'name')
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
            'index' => Pages\ListChildCategories::route('/'),
            'create' => Pages\CreateChildCategory::route('/create'),
            'edit' => Pages\EditChildCategory::route('/{record}/edit'),
        ];
    }
}
