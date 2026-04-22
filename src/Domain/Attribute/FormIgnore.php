<?php
declare(strict_types=1);

namespace Iriven\Fluxa\Domain\Attribute;

use Attribute;

#[Attribute(Attribute::TARGET_PROPERTY)]
final class FormIgnore
{
}
