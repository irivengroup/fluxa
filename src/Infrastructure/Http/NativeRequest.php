<?php

declare(strict_types=1);

namespace Iriven\PhpFormGenerator\Infrastructure\Http;

use Iriven\PhpFormGenerator\Domain\Contract\RequestInterface;
use Iriven\PhpFormGenerator\Domain\ValueObject\UploadedFile;

final class NativeRequest implements RequestInterface
{
    /**
     * @param array<string, mixed> $request
     * @param array<string, mixed> $files
     */
    public function __construct(
        private readonly string $method = 'GET',
        private readonly array $request = [],
        private readonly array $files = [],
    ) {
    }

    public function getMethod(): string
    {
        return strtoupper($this->method);
    }

    /**
     * @return array<string, mixed>
     */
    public function all(): array
    {
        return array_replace_recursive($this->request, $this->normalizeFiles($this->files));
    }

    public function get(string $key, mixed $default = null): mixed
    {
        $data = $this->all();

        return $data[$key] ?? $default;
    }

    /**
     * @param array<string, mixed> $files
     * @return array<string, mixed>
     */
    private function normalizeFiles(array $files): array
    {
        $normalized = [];
        foreach ($files as $field => $spec) {
            if (!is_array($spec) || !isset($spec['name'], $spec['type'], $spec['tmp_name'], $spec['error'], $spec['size'])) {
                $normalized[$field] = $spec;
                continue;
            }

            if (is_array($spec['name'])) {
                $items = [];
                foreach (array_keys($spec['name']) as $index) {
                    $items[] = new UploadedFile(
                        (string) $spec['name'][$index],
                        (string) $spec['type'][$index],
                        (int) $spec['size'][$index],
                        (string) $spec['tmp_name'][$index],
                        (int) $spec['error'][$index],
                    );
                }
                $normalized[$field] = $items;
                continue;
            }

            $normalized[$field] = new UploadedFile(
                (string) $spec['name'],
                (string) $spec['type'],
                (int) $spec['size'],
                (string) $spec['tmp_name'],
                (int) $spec['error'],
            );
        }

        return $normalized;
    }
}
