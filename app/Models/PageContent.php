<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PageContent extends Model
{
    use HasFactory;
    
    /**
     * Atribut yang dapat diisi
     *
     * @var array
     */
    protected $fillable = [
        'section',
        'key',
        'value',
        'type',
        'is_active',
        'sort_order'
    ];
    
    /**
     * Atribut yang harus di-cast
     *
     * @var array
     */
    protected $casts = [
        'is_active' => 'boolean',
    ];
    
    /**
     * Dapatkan konten halaman berdasarkan section
     *
     * @param string $section
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public static function getContentsBySection(string $section)
    {
        return self::where('section', $section)
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->get();
    }
    
    /**
     * Dapatkan nilai konten berdasarkan section dan key
     *
     * @param string $section
     * @param string $key
     * @param mixed $default
     * @return mixed
     */
    public static function getContent(string $section, string $key, $default = null)
    {
        $content = self::where('section', $section)
            ->where('key', $key)
            ->where('is_active', true)
            ->first();
            
        return $content ? $content->value : $default;
    }
}
