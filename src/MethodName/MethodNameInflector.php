<?php

declare(strict_types=1);

namespace AstrotechLabs\Yii2Tactician\MethodName;

interface MethodNameInflector
{
    public function getMethodName(string $commandClassName): string;
}
