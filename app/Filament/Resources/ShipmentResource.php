<?php

namespace App\Filament\Resources;

use App\Models\Shipment;
use App\Models\ShipmentStatus;
use App\Support\Phone;
use Filament\Actions\Action;
use Filament\Actions\EditAction;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class ShipmentResource extends Resource
{
    protected static ?string $model = Shipment::class;

    protected static ?string $modelLabel = 'شحنة';

    protected static ?string $pluralModelLabel = 'الشحنات';

    public static function getPages(): array
    {
        return ['index' => Pages\ManageShipments::route('/')];
    }

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            Select::make('country')->label('مفتاح الدولة')->options(fn () => Phone::countries())
                ->searchable()->default('SA')->required()->visibleOn('create'),
            TextInput::make('phone')->label('جوال العميل')->tel()->required()->maxLength(30)->visibleOn('create'),
            Select::make('shipment_status_id')->label('الحالة الأولى')->required()
                ->options(fn () => ShipmentStatus::orderBy('id')->pluck('name', 'id'))
                ->default(fn () => ShipmentStatus::min('id'))->visibleOn('create'),
            TextInput::make('destination')->label('الوجهة')->maxLength(150),
            Select::make('method')->label('طريقة الشحن')->options(['بحري' => 'بحري', 'جوي' => 'جوي', 'بري' => 'بري']),
            TextInput::make('weight')->label('الوزن مع الوحدة')->placeholder('25 كجم')->maxLength(50),
            Textarea::make('details')->label('تفاصيل تظهر للعميل')->maxLength(2000),
            FileUpload::make('photos')->label('صور تظهر للعميل')->image()
                ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp'])->disk('local')->visibility('private')
                ->directory('shipment-photos')->multiple()->maxFiles(6)->maxSize(4096)->preventFilePathTampering(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table->defaultSort('id', 'desc')->columns([
            TextColumn::make('number')->label('رقم التتبع')->searchable()->copyable(),
            TextColumn::make('customer.phone')->label('جوال العميل')->searchable(),
            TextColumn::make('latestEvent.status.name')->label('الحالة الحالية')->badge(),
            TextColumn::make('destination')->label('الوجهة'),
        ])->recordActions([
            EditAction::make(),
            Action::make('updateStatus')->label('تحديث الحالة')
                ->schema([
                    Select::make('shipment_status_id')->label('الحالة')->required()
                        ->options(fn () => ShipmentStatus::orderBy('id')->pluck('name', 'id')),
                    TextInput::make('location')->label('الموقع أو ملاحظة للعميل')->maxLength(250),
                ])->action(fn (Shipment $record, array $data) => $record->events()->create($data)),
            Action::make('whatsapp')->label('إرسال عبر واتساب')->openUrlInNewTab()
                ->url(fn (Shipment $record) => 'https://wa.me/'.ltrim($record->customer->phone, '+').'?text='.rawurlencode($record->message())),
            Action::make('share')->label('رسالة WeChat')->modalHeading('انسخ الرسالة وأرسلها للعميل في WeChat')
                ->modalContent(fn (Shipment $record) => view('rialchi.partials.share-shipment', ['shipment' => $record]))
                ->modalSubmitAction(false)->modalCancelActionLabel('إغلاق'),
        ]);
    }
}
