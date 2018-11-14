<?php declare(strict_types=1);

namespace MF\Bulletproof;

use MF\Bulletproof\Internal\Type;

interface ClassInferenceInterface extends TypeInferenceInterface
{
    /** @return Type[] */
    public function deduceType(string $class, string $method): array;

    public function deduceReturnType(string $class, string $method): Type;
}
