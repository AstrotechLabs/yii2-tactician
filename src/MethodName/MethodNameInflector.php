<?php

declare(strict_types=1);

namespace DersonSena\Yii2Tactician\MethodName;

interface MethodNameInflector
{
    public function getMethodName(string $commandClassName): string;
}
