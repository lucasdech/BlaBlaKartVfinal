<?php

namespace App\Filament\Resources\UserResource\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use App\Models\User;

class UserOverview extends BaseWidget
{
    public $record;

    protected function getStats(): array
    {
        // Ensure $record is a User model instance
        $user = $this->record instanceof User ? $this->record : User::find($this->record['id']);

        if (!$user) {
            return [];
        }

        return [
            Stat::make('Name', $user->firstname . ' ' . $user->lastname)
                ->description('User\'s full name'),
            Stat::make('Email', $user->email)
                ->description('User\'s email address'),
            Stat::make('Role', ucfirst($user->role))
                ->description('User\'s role in the system'),
        ];
    }
}