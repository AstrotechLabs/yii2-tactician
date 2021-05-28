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
        if (is_string($command)) {
            if (empty($parameters)) {
                throw new InvalidArgumentException("You must provide parameters when command is a string path.");
            }

            /** @var \DersonSena\Yii2Tactician\Handler $handleObject */
            $handleObject = Yii::$container->get($command);

            if (!($handleObject instanceof Handler)) {
                throw new RuntimeException("Handler class '" . get_class($handleObject) . "' must implements '" . Handler::class . "' interface.");
            }

            if (!method_exists($handleObject, 'handle')) {
                throw new RuntimeException("Handler class '" . get_class($handleObject) . "' must be a handle method.");
            }

            $commandClass = $handleObject->commandClassName();

            if (!class_exists($commandClass)) {
                throw new RuntimeException("Command class '{$commandClass}' doesn't exists.");
            }

            /** @var Command $command */
            $command = $commandClass::create($parameters);

            if (!($command instanceof Command)) {
                throw new RuntimeException("Command class must implements '" . Command::class . "' interface.");
            }

            return call_user_func_array([$handleObject, 'handle'], [$command]);
        }

        return call_user_func_array([$this->commandBus, 'handle'], [$command]);
    }
}
