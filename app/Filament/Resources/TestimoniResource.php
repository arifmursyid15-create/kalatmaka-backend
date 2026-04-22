<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TestimoniResource\Pages;
use App\Models\Testimoni;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class TestimoniResource extends Resource
{
    protected static ?string $model = Testimoni::class;
    protected static ?string $navigationIcon = 'heroicon-o-chat-bubble-left-right';
    protected static ?string $navigationLabel = 'Testimoni';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\TextInput::make('nama')
                ->required()->maxLength(255),
            Forms\Components\TextInput::make('lokasi')
                ->maxLength(255),
            Forms\Components\Textarea::make('isi')
                ->required()->rows(4),
            Forms\Components\Select::make('rating')
                ->options([
                    1 => '⭐',
                    2 => '⭐⭐',
                    3 => '⭐⭐⭐',
                    4 => '⭐⭐⭐⭐',
                    5 => '⭐⭐⭐⭐⭐',
                ])->default(5)->required(),
            Forms\Components\FileUpload::make('foto')
                ->image()
                ->directory('testimoni')
                ->nullable(),
            Forms\Components\Toggle::make('is_active')
                ->default(true),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            Tables\Columns\TextColumn::make('nama'),
            Tables\Columns\TextColumn::make('lokasi'),
            Tables\Columns\TextColumn::make('isi')->limit(50),
            Tables\Columns\TextColumn::make('rating'),
            Tables\Columns\IconColumn::make('is_active')->boolean(),
        ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTestimonis::route('/'),
            'create' => Pages\CreateTestimoni::route('/create'),
            'edit' => Pages\EditTestimoni::route('/{record}/edit'),
        ];
    }
}