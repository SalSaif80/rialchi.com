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

    public static function getNavigationGroup(): ?string
    {
        return __('الشحن والتتبع');
    }

    public static function getModelLabel(): string
    {
        return __('شحنة');
    }

    public static function getPluralModelLabel(): string
    {
        return __('الشحنات');
    }

    public static function getPages(): array
    {
        return ['index' => Pages\ManageShipments::route('/')];
    }

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            Select::make('country')->label(__('مفتاح الدولة'))->options(fn () => Phone::countries())
                ->searchable()->default('SA')->required()->visibleOn('create'),
            TextInput::make('phone')->label(__('جوال العميل'))->tel()->required()->maxLength(30)->visibleOn('create'),
            Select::make('shipment_status_id')->label(__('الحالة الأولى'))->required()
                ->options(fn () => ShipmentStatus::orderBy('id')->get()->pluck('translated_name', 'id'))
                ->default(fn () => ShipmentStatus::min('id'))->visibleOn('create'),
            TextInput::make('destination')->label(__('الوجهة'))->maxLength(150),
            Select::make('method')->label(__('طريقة الشحن'))->options(['بحري' => __('بحري'), 'جوي' => __('جوي'), 'بري' => __('بري')]),
            TextInput::make('weight')->label(__('الوزن مع الوحدة'))->placeholder(__('25 كجم'))->maxLength(50),
            Textarea::make('details')->label(__('تفاصيل تظهر للعميل'))->maxLength(2000),
            FileUpload::make('photos')->label(__('صور المنتج الداخلية'))->image()
                ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp'])->disk('local')->visibility('private')
                ->directory('shipment-photos')->multiple()->maxFiles(6)->maxSize(4096)->preventFilePathTampering(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table->defaultSort('id', 'desc')->columns([
            TextColumn::make('number')->label(__('رقم التتبع'))->searchable()->copyable(),
            TextColumn::make('customer.phone')->label(__('جوال العميل'))->searchable(),
            TextColumn::make('latestEvent.status.name')->label(__('الحالة الحالية'))->formatStateUsing(fn (Shipment $record) => $record->latestEvent?->status?->translated_name)->badge(),
            TextColumn::make('destination')->label(__('الوجهة')),
        ])->recordActions([
            Action::make('photos')->label(__('عرض صور المنتج'))
                ->visible(fn (Shipment $record) => filled($record->photos))
                ->modalHeading(fn (Shipment $record) => __('صور المنتج · ').$record->number)
                ->modalContent(fn (Shipment $record) => view('rialchi.partials.shipment-photos', ['shipment' => $record]))
                ->modalSubmitAction(false)->modalCancelActionLabel(__('إغلاق')),
            EditAction::make(),
            Action::make('updateStatus')->label(__('تحديث الحالة'))
                ->schema([
                    Select::make('shipment_status_id')->label(__('الحالة'))->required()
                        ->options(fn () => ShipmentStatus::orderBy('id')->get()->pluck('translated_name', 'id')),
                    TextInput::make('location')->label(__('الموقع أو ملاحظة للعميل'))->maxLength(250),
                ])->action(fn (Shipment $record, array $data) => $record->events()->create($data)),
            Action::make('whatsapp')->label(__('إرسال عبر واتساب'))->openUrlInNewTab()
                ->url(fn (Shipment $record) => 'https://wa.me/'.ltrim($record->customer->phone, '+').'?text='.rawurlencode($record->message())),
            Action::make('share')->label(__('رسالة WeChat'))->modalHeading(__('انسخ الرسالة وأرسلها للعميل في WeChat'))
                ->modalContent(fn (Shipment $record) => view('rialchi.partials.share-shipment', ['shipment' => $record]))
                ->modalSubmitAction(false)->modalCancelActionLabel(__('إغلاق')),
        ]);
    }
}
