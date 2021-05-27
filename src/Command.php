<?php

declare(strict_types=1);

namespace DersonSena\Yii2Tactician;

interface Command
{
    /**
     * Factory method to create and fill your command class
     * @param array $parameters
     * @return Command
     */
    public static function create(array $parameters): Command;
}
