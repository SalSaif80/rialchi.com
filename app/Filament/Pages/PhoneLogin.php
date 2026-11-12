<?php

namespace App\Filament\Pages;

use App\Support\Phone;
use Filament\Auth\Pages\Login;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Component;
use Illuminate\Validation\ValidationException;

class PhoneLogin extends Login
{
    protected function getEmailFormComponent(): Component
    {
        return TextInput::make('phone')->label(__('رقم الجوال'))->tel()->required()
            ->placeholder('+966…')->autocomplete('username')->autofocus();
    }

    protected function getCredentialsFromFormData(array $data): array
    {
        return ['phone' => Phone::normalize($data['phone']) ?? '', 'password' => $data['password']];
    }

    protected function throwFailureValidationException(): never
    {
        throw ValidationException::withMessages(['data.phone' => __('تحقق من رقم الجوال وكلمة المرور.')]);
    }
}
