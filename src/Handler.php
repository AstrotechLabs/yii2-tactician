<?php

declare(strict_types=1);

namespace AstrotechLabs\Yii2Tactician;

interface Handler
{
    public function commandClassName(): string;
}
