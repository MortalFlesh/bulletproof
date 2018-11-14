<?php declare(strict_types=1);

namespace MF\Bulletproof;

use MF\Bulletproof\Internal\Type;

interface CallableInferenceInterface extends TypeInferenceInterface
{
    /** @return Type[] */
    public function deduceType(callable $function): array;

    public function deduceReturnType(callable $function): Type;
}
