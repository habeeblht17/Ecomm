<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Vendor;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Select;
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
use App\Filament\Resources\VendorResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\VendorResource\RelationManagers;

class VendorResource extends Resource
{
    protected static ?string $model = Vendor::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Group::make()->schema([

                    Section::make('Vendor Media')->schema([

                        FileUpload::make('logo')
                        ->directory('vendor/logos')
                        ->preserveFilenames()
                        ->image()
                        ->imageEditor()
                        ->required(),

                        FileUpload::make('banner')
                        ->directory('vendor/banners')
                        ->preserveFilenames()
                        ->image()
                        ->imageEditor()
                        ->required(),

                    ])->columns(2),

                ])->columnSpan('full'),

                //Vendor info
                Group::make()->schema([

                    Section::make('Vendor Info')->schema([

                        TextInput::make('name')
                        ->required()
                        ->maxLength(225),

                        TextInput::make('phone')
                        ->required()
                        ->tel(),

                        TextInput::make('email')
                        ->required()
                        ->email()
                        ->maxLength(225),

                        TextInput::make('address')
                        ->label('Vendor Address')
                        ->required()
                        ->string()
                        ->maxLength(225),

                        MarkdownEditor::make('description')
                        ->required()
                        ->string()
                        ->columnSpanFull(),

                    ])->columns(2),

                ])->columnSpan('full'),

                // Relationship and Status
                Group::make()->schema([

                    Section::make('Association')->schema([

                        Select::make('user_id')
                        ->relationship('user', 'name')
                        ->required()
                        ->searchable()
                        ->preload()
                        ->native(false),

                    ]),

                    Section::make('Status')->schema([

                        Toggle::make('is_visible')
                        ->label('Visibility')
                        ->helperText('Enable or Disable  Vendor Visibility')
                        ->default(true),

                        Toggle::make('is_approved')
                        ->label('Accessibility')
                        ->helperText('Approved or Disapproved Vendor'),

                    ]),

                ]),

                //Social Links
                Group::make()->schema([

                    Section::make('Social Links')->schema([
                        TextInput::make('fb_link')
                        ->label('Facebook Link')
                        ->url()
                        ->suffixIcon('heroicon-m-globe-alt'),

                        TextInput::make('tw_link')
                        ->label('Twitter Link Now (X)')
                        ->url()
                        ->suffixIcon('heroicon-m-globe-alt'),

                        TextInput::make('insta_link')
                        ->label('Instagram Link')
                        ->url()
                        ->suffixIcon('heroicon-m-globe-alt'),
                    ]),

                ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('logo'),

                ImageColumn::make('banner'),

                TextColumn::make('user.name')
                ->searchable()
                ->sortable()
                ->toggleable(),

                TextColumn::make('name')
                ->searchable()
                ->sortable(),

                TextColumn::make('phone')
                ->searchable()
                ->sortable()
                ->toggleable(),

                TextColumn::make('email')
                ->searchable()
                ->sortable()
                ->toggleable(),

                TextColumn::make('address')
                ->searchable()
                ->sortable()
                ->toggleable(),

                TextColumn::make('fb_link')
                ->label('Facebook Link')
                ->toggleable(),

                TextColumn::make('tw_link')
                ->label('Twitter Link')
                ->toggleable(),

                TextColumn::make('insta_link')
                ->label('Instagram Link')
                ->toggleable(),

                IconColumn::make('is_visible')
                ->boolean()
                ->label('Visibility')
                ->sortable()
                ->toggleable(),

                IconColumn::make('is_approved')
                ->boolean()
                ->label('Accessibility')
                ->sortable()
                ->toggleable(),
            ])
            ->filters([
                TernaryFilter::make('is_visible')
                ->label('Visibility')
                ->boolean()
                ->trueLabel('Only Visible Vendors')
                ->falseLabel('Only Hidden Vendors')
                ->native(false),

                TernaryFilter::make('is_approved')
                ->label('Accessibility')
                ->boolean()
                ->trueLabel('Only Accessible Vendors')
                ->falseLabel('Only Hidden Vendors')
                ->native(false),

                SelectFilter::make('user')
                ->relationship('user', 'name')
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
            'index' => Pages\ListVendors::route('/'),
            'create' => Pages\CreateVendor::route('/create'),
            'edit' => Pages\EditVendor::route('/{record}/edit'),
        ];
    }
}
