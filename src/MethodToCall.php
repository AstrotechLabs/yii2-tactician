<?php

declare(strict_types=1);

namespace DersonSena\Yii2Tactician;

use DersonSena\Yii2Tactician\Exceptions\MethodDoesNotExist;

final class MethodToCall
{
    private string $className;
    private string $methodName;

    public function __construct(string $className, string $methodName)
    {
        if (!method_exists($className, $methodName) && ! method_exists($className, '__call')) {
            throw MethodDoesNotExist::on($className, $methodName);
        }

        $this->className  = $className;
        $this->methodName = $methodName;
    }

    public function getClassName(): string
    {
        return $this->className;
    }

    public function getMethodName(): string
    {
        return $this->methodName;
    }
}
