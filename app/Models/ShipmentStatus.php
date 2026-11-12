<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ShipmentStatus extends Model
{
    protected $fillable = ['name', 'code', 'name_en', 'name_zh'];

    public function getTranslatedNameAttribute(): string
    {
        $translated = match (app()->getLocale()) {
            'en' => $this->name_en,
            'zh_CN' => $this->name_zh,
            default => null,
        };

        return filled($translated) ? $translated : __($this->name);
    }
}
