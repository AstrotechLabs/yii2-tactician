<?php

declare(strict_types=1);

namespace DersonSena\Yii2Tactician\ClassName;

interface ClassNameInflector
{
    public function getClassName(string $commandClassName): string;
}
