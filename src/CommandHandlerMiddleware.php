<?php

declare(strict_types=1);

namespace DersonSena\Yii2Tactician;

use League\Tactician\Middleware;
use yii\di\Container;

final class CommandHandlerMiddleware implements Middleware
{
    private Container $container;
    private CommandToHandlerMapping $mapping;

    public function __construct(Container $container, CommandToHandlerMapping $mapping)
    {
        $this->container = $container;
        $this->mapping = $mapping;
    }

    public function execute($command, callable $next)
    {
        $methodToCall = $this->mapping->mapCommandToHandler(get_class($command));
        $handler = $this->container->get($methodToCall->getClassName());

        return $handler->{$methodToCall->getMethodName()}($command);
    }
}
