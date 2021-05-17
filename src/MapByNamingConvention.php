<?php

declare(strict_types=1);

namespace DersonSena\Yii2Tactician;

use DersonSena\Yii2Tactician\ClassName\ClassNameInflector;
use DersonSena\Yii2Tactician\MethodName\MethodNameInflector;

final class MapByNamingConvention implements CommandToHandlerMapping
{
    private ClassNameInflector $classNameInflector;
    private MethodNameInflector $methodNameInflector;

    public function __construct(
        ClassNameInflector $classNameInflector,
        MethodNameInflector $methodNameInflector
    ) {
        $this->classNameInflector  = $classNameInflector;
        $this->methodNameInflector = $methodNameInflector;
    }

    public function mapCommandToHandler(string $commandFQCN): MethodToCall
    {
        return new MethodToCall(
            $this->classNameInflector->getClassName($commandFQCN),
            $this->methodNameInflector->getMethodName($commandFQCN)
        );
    }
}
