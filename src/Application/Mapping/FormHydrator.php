<?php
declare(strict_types=1);

namespace Iriven\PhpFormGenerator\Application\Mapping;

/** @api */
final class FormHydrator
{
    public function __construct(
        private readonly ObjectFormMapper $mapper = new ObjectFormMapper(),
        private readonly PropertyPathNormalizer $normalizer = new PropertyPathNormalizer(),
    ) {}

    /**
     * @param array<string, mixed> $payload
     * @param object|array<string, mixed> $target
     * @return array<string, mixed>
     */
    public function hydrate(array $payload, object|array $target = []): array
    {
        if ($payload === []) {
            return is_array($target) ? $target : $this->mapper->extract($target);
        }

        $normalized = [];
        foreach ($payload as $key => $value) {
            $normalized[$this->normalizer->normalize((string) $key)] = $value;
        }

        return $this->mapper->hydrate($normalized, $target);
    }
}
