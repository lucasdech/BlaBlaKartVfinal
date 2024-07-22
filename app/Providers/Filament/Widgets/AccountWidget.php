<?php

namespace App\Providers\Filament\Widgets;

use Filament\Widgets\AccountWidget as BaseAccountWidget;

class AccountWidget extends BaseAccountWidget
{
    protected function getUser(): array
    {
        $user = auth()->user();
        $firstname = $user->firstname ?? 'Default Firstname';
        $lastname = $user->lastname ?? 'Default Lastname';

        return [
            'name' => $firstname . ' ' . $lastname,
            'email' => $user->email,
        ];
    }
}
