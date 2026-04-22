<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PortfolioResource\Pages;
use App\Models\Portfolio;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class PortfolioResource extends Resource
{
    protected static ?string $model = Portfolio::class;
    protected static ?string $navigationIcon = 'heroicon-o-photo';
    protected static ?string $navigationLabel = 'Portofolio';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\TextInput::make('judul')
                ->required()->maxLength(255),
            Forms\Components\Select::make('kategori')
                ->options([
                    'Desain Interior' => 'Desain Interior',
                    'Plafon PVC' => 'Plafon PVC',
                    'Wallpanel' => 'Wallpanel',
                    'Gorden' => 'Gorden',
                ])->required(),
            Forms\Components\TextInput::make('lokasi')
                ->maxLength(255),
            Forms\Components\Textarea::make('deskripsi'),
            Forms\Components\FileUpload::make('foto')
                ->image()
                ->directory('portfolio')
                ->required(),
            Forms\Components\Toggle::make('is_active')
                ->default(true),
            Forms\Components\TextInput::make('urutan')
                ->numeric()->default(0),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            Tables\Columns\ImageColumn::make('foto')
                ->disk('public'),
            Tables\Columns\TextColumn::make('judul'),
            Tables\Columns\TextColumn::make('kategori'),
            Tables\Columns\TextColumn::make('lokasi'),
            Tables\Columns\IconColumn::make('is_active')->boolean(),
        ])->defaultSort('urutan');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPortfolios::route('/'),
            'create' => Pages\CreatePortfolio::route('/create'),
            'edit' => Pages\EditPortfolio::route('/{record}/edit'),
        ];
    }
}