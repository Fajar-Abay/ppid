<?php
declare(strict_types=1);
namespace App\Filament\Resources\SettingResource\Pages;
use App\Filament\Resources\SettingResource;
use Filament\Resources\Pages\CreateRecord;
class CreateSetting extends CreateRecord 
{ 
    protected static string $resource = SettingResource::class; 
    
    protected function mutateFormDataBeforeCreate(array $data): array
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
