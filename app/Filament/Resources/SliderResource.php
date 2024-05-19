<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Slider;
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
use Filament\Tables\Columns\ImageColumn;
use Filament\Forms\Components\FileUpload;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\SliderResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\SliderResource\RelationManagers;

class SliderResource extends Resource
{
    protected static ?string $model = Slider::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = 'Manage Slider';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Group::make()->schema([

                    Section::make('Banner Info')->schema([

                        TextInput::make('name')
                        ->required()
                        ->maxLength(255),

                        TextInput::make('type')
                        ->required()
                        ->unique()
                        ->maxLength(255),

                        TextInput::make('starting_price')
                        ->numeric()
                        ->inputMode('decimal'),

                        TextInput::make('serial')
                        ->unique()
                        ->required()
                        ->integer(),

                    ]),
                ]),

                Group::make()->schema([

                    Section::make()->schema([
                        TextInput::make('btn_url')
                        ->label('Botton Url')
                        ->required()
                        ->url()
                        ->suffixIcon('heroicon-m-globe-alt'),

                        Section::make('Status')->schema([

                            Toggle::make('status')
                            ->label('Activate/Inactivate')
                            ->helperText('Enable or Disable Banner Activeness')
                            ->default(true),

                        ]),

                        Section::make('Banner Image')->schema([

                            FileUpload::make('banner')
                            ->directory('banners')
                            ->preserveFilenames()
                            ->image()
                            ->imageEditor()
                            ->required(),

                        ])->collapsible(),
                    ]),


                ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('banner'),

                TextColumn::make('name')
                ->searchable()
                ->sortable(),

                TextColumn::make('type')
                ->searchable()
                ->toggleable(),

                TextColumn::make('starting_price')
                ->searchable()
                ->sortable()
                ->toggleable(),

                TextColumn::make('btn_url')
                ->label('Button Url')
                ->searchable()
                ->sortable()
                ->toggleable(),

                IconColumn::make('status')
                ->boolean()
                ->label('Status')
                ->toggleable(),
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
            'index' => Pages\ListSliders::route('/'),
            'create' => Pages\CreateSlider::route('/create'),
            'edit' => Pages\EditSlider::route('/{record}/edit'),
        ];
    }
}
