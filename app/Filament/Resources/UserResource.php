<?php

namespace App\Filament\Resources;

use App\Models\User;
use App\Support\Phone;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $modelLabel = 'مستخدم';

    protected static ?string $pluralModelLabel = 'المستخدمون';

    public static function getPages(): array
    {
        return ['index' => Pages\ManageUsers::route('/')];
    }

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            TextInput::make('name')->label('الاسم')->required()->maxLength(120),
            TextInput::make('phone')->label('رقم الجوال بمفتاح الدولة')->tel()->placeholder('+966551234567')
                ->required()->rule('regex:/^\+[1-9][0-9]{6,14}$/')->unique(ignoreRecord: true)
                ->rule(fn () => function ($attribute, $value, $fail) {
                    if (Phone::normalize($value) !== $value) {
                        $fail('أدخل رقم جوال دوليًا صحيحًا.');
                    }
                })->disabled(fn (?User $record) => (bool) $record?->is_owner),
            Select::make('role')->label('الصلاحية')->required()
                ->options(['staff' => 'موظف شحن', 'admin' => 'مدير النظام'])->default('staff')
                ->disabled(fn (?User $record) => $record && ($record->is_owner || $record->is(auth()->user()))),
            TextInput::make('password')->label('كلمة المرور')->password()->revealable()->minLength(12)
                ->autocomplete('new-password')->required(fn (string $operation) => $operation === 'create')
                ->dehydrated(fn ($state) => filled($state))->afterStateHydrated(fn (TextInput $component) => $component->state('')),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            TextColumn::make('name')->label('الاسم')->searchable(),
            TextColumn::make('phone')->label('الجوال')->searchable(),
            TextColumn::make('role')->label('الصلاحية')->formatStateUsing(fn ($state) => $state === 'admin' ? 'مدير' : 'موظف'),
        ])->recordActions([EditAction::make(), DeleteAction::make()]);
    }
}
