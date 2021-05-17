<?php

declare(strict_types=1);

namespace DersonSena\Yii2Tactician\ClassName;

final class Suffix implements ClassNameInflector
{
    private string $suffix;

    public function __construct(string $suffix)
    {
        $this->suffix = $suffix;
    }

    public function getClassName(string $commandClassName): string
    {
        // Command class name without "Command" + Suffix (most of time "Handler")
        return str_replace('Command', '', $commandClassName) . $this->suffix;
    }
}
