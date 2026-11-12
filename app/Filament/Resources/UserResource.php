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

    public static function getNavigationGroup(): ?string
    {
        return __('إدارة الصلاحيات');
    }

    public static function getModelLabel(): string
    {
        return __('مستخدم');
    }

    public static function getPluralModelLabel(): string
    {
        return __('المستخدمون');
    }

    public static function getPages(): array
    {
        return ['index' => Pages\ManageUsers::route('/')];
    }

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            TextInput::make('name')->label(__('الاسم'))->required()->maxLength(120),
            TextInput::make('phone')->label(__('رقم الجوال بمفتاح الدولة'))->tel()->placeholder('+966551234567')
                ->required()->rule('regex:/^\+[1-9][0-9]{6,14}$/')->unique(ignoreRecord: true)
                ->rule(fn () => function ($attribute, $value, $fail) {
                    if (Phone::normalize($value) !== $value) {
                        $fail(__('أدخل رقم جوال دوليًا صحيحًا.'));
                    }
                })->disabled(fn (?User $record) => (bool) $record?->is_owner),
            Select::make('role')->label(__('الصلاحية'))->required()
                ->options(['staff' => __('موظف شحن'), 'admin' => __('مدير النظام')])->default('staff')
                ->disabled(fn (?User $record) => $record && ($record->is_owner || $record->is(auth()->user()))),
            TextInput::make('password')->label(__('كلمة المرور'))->password()->revealable()->minLength(12)
                ->autocomplete('new-password')->required(fn (string $operation) => $operation === 'create')
                ->dehydrated(fn ($state) => filled($state))->afterStateHydrated(fn (TextInput $component) => $component->state('')),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            TextColumn::make('name')->label(__('الاسم'))->searchable(),
            TextColumn::make('phone')->label(__('الجوال'))->searchable(),
            TextColumn::make('role')->label(__('الصلاحية'))->formatStateUsing(fn ($state) => $state === 'admin' ? __('مدير') : __('موظف')),
        ])->recordActions([EditAction::make(), DeleteAction::make()]);
    }
}
