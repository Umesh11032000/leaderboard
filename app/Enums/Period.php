<?php

namespace App\Enums;

enum Period: string
{
    case DAY = 'day';
    case WEEK = 'week';
    case MONTH = 'month';

    public function name(): string
    {
        return match ($this) {
            self::DAY => 'Day',
            self::WEEK => 'Week',
            self::MONTH => 'Month',
        };
    }

    public static function toArray(): array
    {
        return [
            self::DAY,
            self::WEEK,
            self::MONTH,
        ];
    }

    public static function values(): array
    {
        return array_map(fn (Period $period) => $period->name(), self::toArray());
    }

    public static function choices(): array
    {
        return [
            'day' => 'Day',
            'week' => 'Week',
            'month' => 'Month',
        ];
    }

    public static function options(): array
    {
        return [
            'Day' => 'day',
            'Week' => 'week',
            'Month' => 'month',
        ];
    }

    public static function default(): self
    {
        return self::DAY;
    }

    public static function fromName(string $name): self
    {
        return match ($name) {
            'Day' => self::DAY,
            'Week' => self::WEEK,
            'Month' => self::MONTH,
        };
    }

    public static function fromValue(string $value): self
    {
        return match ($value) {
            'day' => self::DAY,
            'week' => self::WEEK,
            'month' => self::MONTH,
        };
    }

    public function value(): string
    {
        return match ($this) {
            self::DAY => 'day',
            self::WEEK => 'week',
            self::MONTH => 'month',
        };
    }
    
    public function days(): int
    {
        return match ($this) {
            self::DAY => 1,
            self::WEEK => 7,
            self::MONTH => 30,
        };
    }

    public function range(): array
    {
        return match ($this) {
            self::DAY => [
                now()->startOfDay(),
                now()->endOfDay(),
            ],
            self::WEEK => [
                now()->startOfWeek(),
                now()->endOfWeek(),
            ],
            self::MONTH => [
                now()->startOfMonth(),
                now()->endOfMonth(),
            ],
        };
    }
}
