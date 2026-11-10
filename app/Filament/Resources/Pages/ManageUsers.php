<?php

namespace App\Filament\Resources\Pages;

use App\Filament\Resources\UserResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ManageRecords;
use Illuminate\Support\Str;

class ManageUsers extends ManageRecords
{
    protected static string $resource = UserResource::class;

    protected function getHeaderActions(): array
    {
        return [CreateAction::make()->label('إضافة مستخدم')->mutateDataUsing(fn (array $data) => $data + ['email' => Str::uuid().'@users.invalid'])];
    }
}
