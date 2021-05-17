<?php

declare(strict_types=1);

namespace DersonSena\Yii2Tactician;

use Yii;
use DersonSena\Yii2Tactician\Exceptions\MissingHandleMethodException;
use DersonSena\Yii2Tactician\MethodName\Handle;
use DersonSena\Yii2Tactician\ClassName\Suffix;
use yii\base\Component;
use League\Tactician\CommandBus;
use League\Tactician\Plugins\LockingMiddleware;

final class Yii2TacticianCommandBus extends Component
{
    private CommandBus $commandBus;

    public function init()
    {
        parent::init();

        $handlerMiddleware = new CommandHandlerMiddleware(
            Yii::$container,
            new MapByNamingConvention(new Suffix('Handler'), new Handle())
        );

        $lockingMiddleware = new LockingMiddleware();

        $this->commandBus = new CommandBus([$lockingMiddleware, $handlerMiddleware]);
    }

    public function handle(object $commandObject)
    {
        $callable = [$this->commandBus, 'handle'];

        if (!is_callable($callable)) {
            throw new MissingHandleMethodException();
        }

        return call_user_func_array($callable, [$commandObject]);
    }
}
