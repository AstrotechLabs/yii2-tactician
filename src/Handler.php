<?php

declare(strict_types=1);

namespace DersonSena\Yii2Tactician;

interface Handler
{
    public function commandClassName(): string;
}
