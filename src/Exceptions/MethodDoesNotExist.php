<?php

declare(strict_types=1);

namespace DersonSena\Yii2Tactician\Exceptions;

use BadMethodCallException;
use League\Tactician\Exception\Exception;

final class MethodDoesNotExist extends BadMethodCallException implements Exception
{
    private string $className;
    private string $methodName;

    private function __construct(string $message, string $className, string $methodName)
    {
        parent::__construct($message);
        $this->className  = $className;
        $this->methodName = $methodName;
    }

    public static function on(string $className, string $methodName): self
    {
        return new self(
            'The handler method ' . $className . '::' . $methodName . ' does not exist. Please check your Tactician ' .
            'mapping configuration or check verify that ' . $methodName . ' is actually declared in . ' . $className,
            $className,
            $methodName
        );
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
