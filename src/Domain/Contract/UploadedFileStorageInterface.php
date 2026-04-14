<?php

declare(strict_types=1);

namespace Iriven\PhpFormGenerator\Domain\Contract;

use Iriven\PhpFormGenerator\Domain\ValueObject\UploadedFile;

interface UploadedFileStorageInterface
{
    public function store(UploadedFile $file, ?string $directory = null, ?string $targetName = null): string;
}
