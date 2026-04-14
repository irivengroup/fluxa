<?php

declare(strict_types=1);

namespace Iriven\PhpFormGenerator\Tests;

use Iriven\PhpFormGenerator\Application\FormType\ContactType;
use PHPUnit\Framework\TestCase;

final class ApplicationFormTypesTest extends TestCase
{
    public function testContactTypeClassExists(): void
    {
        self::assertTrue(class_exists(ContactType::class));
    }
}
