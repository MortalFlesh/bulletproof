<?php declare(strict_types=1);

namespace MF\Bulletproof;

interface TypeInferenceInterface
{
    public function deduceType(string $object, string $method): array;

    public function deduceReturnType($object, string $method): string;
}
