<?php

namespace DersonSena\Yii2Tactician;

use DersonSena\Yii2Tactician\Exceptions\FailedToMapCommand;

interface CommandToHandlerMapping
{
    /**
     * @throws FailedToMapCommand
     */
    public function mapCommandToHandler(string $commandFQCN): MethodToCall;
}
