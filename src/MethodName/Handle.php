<?php

declare(strict_types=1);

namespace AstrotechLabs\Yii2Tactician\MethodName;

final class Handle implements MethodNameInflector
{
    public function getMethodName(string $commandClassName): string
    {
        return 'handle';
    }
}
