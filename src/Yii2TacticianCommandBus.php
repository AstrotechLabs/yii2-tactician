<?php

declare(strict_types=1);

namespace DersonSena\Yii2Tactician;

use Yii;
use InvalidArgumentException;
use RuntimeException;
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

    /**
     * @param string|object $command Command class object or string path
     * @param array $parameters (Optional) Parameters to be used when string path is provided
     * @return false|mixed
     * @throws \yii\base\InvalidConfigException
     * @throws \yii\di\NotInstantiableException
     */
    public function handle($command, array $parameters = [])
    {
        $callable = [$this->commandBus, 'handle'];

        if (is_string($command)) {
            if (empty($parameters)) {
                throw new InvalidArgumentException("You must provide parameters when command is a string path.");
            }

            /** @var \DersonSena\Yii2Tactician\Handler $handleObject */
            $handleObject = Yii::$container->get($command);
            $commandClass = $handleObject->commandClassName();

            if (!class_exists($commandClass)) {
                throw new RuntimeException("Command class '{$commandClass}' doesn't exists.");
            }

            if (!is_a($commandClass, Command::class)) {
                throw new RuntimeException("Command class must implements '" . Command::class . "' interface.");
            }

            /** @var Command $command */
            $command = $commandClass::create($parameters);

            return call_user_func_array($callable, [$command]);
        }

        return call_user_func_array($callable, [$command]);
    }
}
