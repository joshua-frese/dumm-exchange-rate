<?php

namespace App\Enums;

/**
 * Holds all known coins
 * 
 * Datenbank wäre die bessere Option
 */
enum CoinEnum: string
{
    case Bitcoin = 'bitcoin';
    case Euro = 'eur';


    /**
     * @return array
     */
    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
    
    public static function names(): array
    {
      return array_column(self::cases(), 'name');
    }
    
    public static function array(): array
    {
      return array_combine(self::values(), self::names());
    }
}