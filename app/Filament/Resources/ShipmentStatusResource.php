<?php

namespace App\Filament\Resources;

use App\Models\ShipmentStatus;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class ShipmentStatusResource extends Resource
{
    protected static ?string $model = ShipmentStatus::class;

    public static function getNavigationGroup(): ?string
    {
        return __('الشحن والتتبع');
    }

    public static function getModelLabel(): string
    {
        return __('حالة');
    }

    public static function getPluralModelLabel(): string
    {
        return __('حالات الشحن');
    }

    public static function getPages(): array
    {
        return ['index' => Pages\ManageShipmentStatuses::route('/')];
    }

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            TextInput::make('name')->label(__('اسم الحالة بالعربية'))->required()->maxLength(100)->unique(ignoreRecord: true),
            TextInput::make('name_en')->label(__('اسم الحالة بالإنجليزية'))->maxLength(100),
            TextInput::make('name_zh')->label(__('اسم الحالة بالصينية'))->maxLength(100),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([TextColumn::make('name')->label(__('الحالة'))->formatStateUsing(fn ($record) => $record->translated_name)->searchable()])
            ->recordActions([EditAction::make(), DeleteAction::make()]);
    }
}
