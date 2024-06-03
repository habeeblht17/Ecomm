<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Slider;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Section;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\ImageColumn;
use Filament\Forms\Components\FileUpload;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Forms\Components\MarkdownEditor;
use App\Filament\Resources\SliderResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\SliderResource\RelationManagers;

class SliderResource extends Resource
{
    protected static ?string $model = Slider::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Group::make()->schema([

                    Section::make()->schema([

                        TextInput::make('type')
                        ->helperText('E.g New Arival, Best Selling Product, etc')
                        ->required()
                        ->columnSpan('full'),

                        TextInput::make('starting_price')
                        ->numeric()
                        ->inputMode('decimal')
                        ->required(),

                        TextInput::make('serial')
                        ->numeric()
                        ->minValue(1)
                        ->required(),

                        MarkdownEditor::make('description')
                        ->required()
                        ->maxLength(200)
                        ->columnSpan('full'),


                    ])->columns(2),
                ]),

                // Section Status
                Group::make()->schema([

                    Section::make('Domain')->schema([
                        TextInput::make('btn_url')
                        ->label('Button Url')
                        ->url()
                        ->suffixIcon('heroicon-m-globe-alt')
                    ]),

                    Section::make('Status')->schema([

                        Toggle::make('is_visible')
                        ->label('Visibility')
                        ->helperText('Enable or Disable  Product Visibility')
                        ->default(true),

                    ]),

                    // Section Image
                    Section::make('Upload Banner Image')->schema([

                        FileUpload::make('banner')
                        ->directory('banners')
                        ->preserveFilenames()
                        ->image()
                        ->imageEditor()
                        ->required(),

                    ])->collapsible(),

                ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('banner'),

                TextColumn::make('type')
                ->searchable()
                ->sortable()
                ->toggleable(),

                TextColumn::make('starting_price')
                ->searchable()
                ->sortable()
                ->toggleable(),

                TextColumn::make('serial')
                ->toggleable(),

                TextColumn::make('btn_url')
                ->label('Botton Url')
                ->toggleable(),

                IconColumn::make('is_visible')
                ->boolean()
                ->label('Visibility')
                ->sortable()
                ->toggleable(),
            ])
            ->filters([
                TernaryFilter::make('is_visible')
                ->label('Visibility')
                ->boolean()
                ->trueLabel('Only Visible Sliders')
                ->falseLabel('Only Hidden Sliders')
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
            'index' => Pages\ListSliders::route('/'),
            'create' => Pages\CreateSlider::route('/create'),
            'edit' => Pages\EditSlider::route('/{record}/edit'),
        ];
    }
}
