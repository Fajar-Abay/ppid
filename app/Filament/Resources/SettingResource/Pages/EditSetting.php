<?php
declare(strict_types=1);
namespace App\Filament\Resources\SettingResource\Pages;
use App\Filament\Resources\SettingResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
class EditSetting extends EditRecord
{
    protected static string $resource = SettingResource::class;
    
    protected function getHeaderActions(): array { return [Actions\DeleteAction::make()]; }

    protected function mutateFormDataBeforeFill(array $data): array
    {
        $type = $data['type'] ?? 'string';
        if ($type === 'image') {
            $data['value_image'] = $data['value'];
        } elseif ($type === 'text') {
            $data['value_text'] = $data['value'];
        } else {
            $data['value_string'] = $data['value'];
        }
        return $data;
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        $type = $data['type'] ?? 'string';
        if ($type === 'image') {
            $data['value'] = $data['value_image'] ?? null;
        } elseif ($type === 'text') {
            $data['value'] = $data['value_text'] ?? null;
        } else {
            $data['value'] = $data['value_string'] ?? null;
        }
        unset($data['value_image'], $data['value_text'], $data['value_string']);
        return $data;
    }
}
