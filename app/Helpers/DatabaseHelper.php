<?php

namespace App\Helpers;

use Illuminate\Support\Facades\DB;

class DatabaseHelper
{
    /**
     * Get database-agnostic date format expression
     * Supports both MySQL and PostgreSQL
     */
    public static function formatDate($column, $format)
    {
        try {
            $driver = config('database.default', 'mysql');
            
            if ($driver === 'pgsql') {
                // PostgreSQL uses TO_CHAR
                $pgFormat = self::convertToPgFormat($format);
                return "TO_CHAR({$column}::timestamp, '{$pgFormat}')";
            }
            
            // MySQL uses DATE_FORMAT
            return "DATE_FORMAT({$column}, '{$format}')";
        } catch (\Exception $e) {
            // Fallback to MySQL format if any error
            return "DATE_FORMAT({$column}, '{$format}')";
        }
    }
    
    /**
     * Convert MySQL date format to PostgreSQL format
     */
    private static function convertToPgFormat($mysqlFormat)
    {
        $conversions = [
            '%M %d, %Y' => 'FMMonth DD, YYYY',      // January 15, 2026
            '%b %d, %Y' => 'Mon DD, YYYY',           // Jan 15, 2026
            '%Y-%m-%d'  => 'YYYY-MM-DD',             // 2026-01-15
            '%M'        => 'FMMonth',                // January
            '%W'        => 'FMDay',                  // Monday
            '%d'        => 'DD',                     // 15
            '%Y'        => 'YYYY',                   // 2026
        ];
        
        return $conversions[$mysqlFormat] ?? 'YYYY-MM-DD';
    }
}
