<?php

use App\Models\User;
use App\Support\Phone;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Str;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Artisan::command('rialchi:password {phone}', function () {
    $phone = Phone::normalize($this->argument('phone'));
    $user = User::where('phone', $phone ?? '')->firstOrFail();
    $password = $this->secret('New password (at least 12 characters)');
    if (! is_string($password) || mb_strlen($password) < 12 || $password !== $this->secret('Confirm password')) {
        $this->error('Password too short or confirmation did not match.');

        return 1;
    }
    $user->password = $password;
    $user->setRememberToken(Str::random(60));
    $user->save();
    $this->info('Password updated.');
})->purpose('Set a panel user password interactively');
