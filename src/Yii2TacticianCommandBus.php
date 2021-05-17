<?php

declare(strict_types=1);

namespace DersonSena\Yii2Tactician;

use Yii;
use yii\base\Component;
use League\Tactician\CommandBus;
use League\Tactician\Handler\CommandNameExtractor\ClassNameExtractor;
use League\Tactician\Handler\Locator\InMemoryLocator;
use League\Tactician\Handler\MethodNameInflector\HandleInflector;
use League\Tactician\Plugins\LockingMiddleware;
use League\Tactician\Handler\CommandHandlerMiddleware;

final class Yii2TacticianCommandBus extends Component
{
    private CommandBus $commandBus;
    public array $commandHandlerMap = [];

    public function init()
    {
        parent::init();

        $commandHandlerMap = array_map(function ($handlerClassName) {
            return Yii::$container->get($handlerClassName);
        }, $this->commandHandlerMap);

        $handlerMiddleware = new CommandHandlerMiddleware(
            new ClassNameExtractor(),
            new InMemoryLocator($commandHandlerMap),
            new HandleInflector()
        );

        $lockingMiddleware = new LockingMiddleware();

        $this->commandBus = new CommandBus([$lockingMiddleware, $handlerMiddleware]);
    }

    public function __call($name, $params)
    {
        $callable = [$this->commandBus, $name];

        if (is_callable($callable)) {
            return call_user_func_array($callable, $params);
        }

        return parent::__call($name, $params);
    }
}
