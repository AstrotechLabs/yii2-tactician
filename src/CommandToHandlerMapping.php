<?php

namespace AstrotechLabs\Yii2Tactician;

use AstrotechLabs\Yii2Tactician\Exceptions\FailedToMapCommand;

interface CommandToHandlerMapping
{
    /**
     * @throws FailedToMapCommand
     */
    public function mapCommandToHandler(string $commandFQCN): MethodToCall;
}
