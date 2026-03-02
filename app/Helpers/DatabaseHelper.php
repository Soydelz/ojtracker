<?php

class DatabaseHelper
{
    /**
     * Format a date column for searching - works with both MySQL and PostgreSQL
     */
    public static function formatDate(string $column, string $mysqlFormat): string
    {
        $driver = config('database.default');
        $connection = config("database.connections.{$driver}.driver");

        if ($connection === 'pgsql') {
            return "TO_CHAR({$column}, '" . self::convertToPgFormat($mysqlFormat) . "')";
        }

        return "DATE_FORMAT({$column}, '{$mysqlFormat}')";
    }

    /**
     * Convert MySQL DATE_FORMAT string to PostgreSQL TO_CHAR format
     */
    private static function convertToPgFormat(string $mysqlFormat): string
    {
        $map = [
            '%M' => 'Month',  // January
            '%b' => 'Mon',    // Jan
            '%m' => 'MM',     // 01
            '%d' => 'DD',     // 15
            '%Y' => 'YYYY',   // 2026
            '%y' => 'YY',     // 26
            '%W' => 'Day',    // Monday
            '%a' => 'Dy',     // Mon
            '%H' => 'HH24',   // 00-23
            '%h' => 'HH12',   // 01-12
            '%i' => 'MI',     // 00-59
            '%s' => 'SS',     // 00-59
            '%p' => 'AM',     // AM/PM
        ];

        return str_replace(array_keys($map), array_values($map), $mysqlFormat);
    }
}
