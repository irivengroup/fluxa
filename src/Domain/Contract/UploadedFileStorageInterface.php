<?php

declare(strict_types=1);

namespace Iriven\Fluxa\Domain\Contract;

use Iriven\Fluxa\Domain\ValueObject\UploadedFile;

interface UploadedFileStorageInterface
{
    public function store(UploadedFile $file, ?string $directory = null, ?string $targetName = null): string;
}
