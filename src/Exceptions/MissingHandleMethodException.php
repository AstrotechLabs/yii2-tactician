<?php

declare(strict_types=1);

namespace AstrotechLabs\Yii2Tactician\Exceptions;

use Exception;
use Throwable;

final class MissingHandleMethodException extends Exception
{
    public function __construct($code = 0, Throwable $previous = null)
    {
        $message = "You must have a 'handle' method in your Handler Class";
        parent::__construct($message, $code, $previous);
    }
}
