<?php

namespace App\Filament\Resources;

use App\Models\ShipmentStatus;
use Filament\Actions\EditAction;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class ShipmentStatusResource extends Resource
{
    protected static ?string $model = ShipmentStatus::class;

    protected static ?string $modelLabel = 'حالة';

    protected static ?string $pluralModelLabel = 'حالات الشحن';

    public static function getPages(): array
    {
        return ['index' => Pages\ManageShipmentStatuses::route('/')];
    }

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            TextInput::make('name')->label('اسم الحالة')->required()->maxLength(100)->unique(ignoreRecord: true),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([TextColumn::make('name')->label('الحالة')->searchable()])
            ->recordActions([EditAction::make()]);
    }
}
