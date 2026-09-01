<?php

declare(strict_types=1);

namespace App\Modules\TaskModule\Enums;

enum TaskStatus: string
{
    case Pending = 'pending';
    case InProgress = 'in_progress';
    case Done = 'done';

    public function label(): string
    {
        return match ($this) {
            self::Pending => 'Pendiente',
            self::InProgress => 'En progreso',
            self::Done => 'Completada',
        };
    }

    public function color(): string
    {
        return match ($this) {
            self::Pending => 'zinc',
            self::InProgress => 'amber',
            self::Done => 'green',
        };
    }

    /**
     * @return array<string, string>
     */
    public static function options(): array
    {
        $options = [];

        foreach (self::cases() as $case) {
            $options[$case->value] = $case->label();
        }

        return $options;
    }
}
