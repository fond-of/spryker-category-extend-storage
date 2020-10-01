<?php

use FondOfSpryker\Shared\Log\LogConstants;
use Monolog\Logger;
use Spryker\Shared\Kernel\KernelConstants;
use Spryker\Yves\Log\Plugin\YvesLoggerConfigPlugin;
use Spryker\Zed\Log\Communication\Plugin\ZedLoggerConfigPlugin;

$CURRENT_STORE = 'UNIT';

$config[KernelConstants::PROJECT_NAMESPACES] = [
    'Pyz',
];

$config[KernelConstants::CORE_NAMESPACES] = [
    'FondOfSpryker',
    'SprykerShop',
    'SprykerEco',
    'Spryker',
];
