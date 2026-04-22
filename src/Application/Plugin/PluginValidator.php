<?php

declare(strict_types=1);

namespace Iriven\Fluxa\Application\Plugin;

use Iriven\Fluxa\Domain\Contract\PluginInterface;
use RuntimeException;

/**
 * @api
 */
final class PluginValidator
{
    public function validate(PluginInterface $plugin): void
    {
        foreach (['registerFieldTypes', 'registerFormTypes', 'registerExtensions'] as $method) {
            if (!method_exists($plugin, $method)) {
                throw new RuntimeException(sprintf('Invalid plugin "%s": missing %s().', $plugin::class, $method));
            }
        }
    }
}
