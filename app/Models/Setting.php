<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Setting extends Model
{
    protected $primaryKey = 'key';
    protected $keyType = 'string';
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = ['key', 'value', 'updated_at'];

    public static function get(string $key, string $default = ''): string
    {
        return Cache::rememberForever('setting_' . $key, function () use ($key, $default) {
            return static::where('key', $key)->value('value') ?? $default;
        });
    }

    public static function set(string $key, mixed $value): void
    {
        static::updateOrCreate(
            ['key' => $key],
            ['value' => $value, 'updated_at' => now()]
        );
        Cache::forget('setting_' . $key);
    }

    public static function allAsArray(): array
    {
        return static::pluck('value', 'key')->toArray();
    }
}
