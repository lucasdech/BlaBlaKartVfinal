<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Resources\UserResource;
use App\Models\User;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewUser extends ViewRecord
{
    protected static string $resource = UserResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }

    protected function getHeaderWidgets(): array
    {
        return [
            UserResource\Widgets\UserOverview::class,
        ];
    }

    protected function getHeaderWidgetsData(): array
    {
        // Ensure we're working with a User model instance
        $record = $this->record instanceof User ? $this->record : User::find($this->record['id']);
        
        return [
            'record' => $record,
        ];
    }
}