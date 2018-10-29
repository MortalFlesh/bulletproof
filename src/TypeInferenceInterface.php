<?php declare(strict_types=1);

namespace MF\Bulletproof;

interface TypeInferenceInterface
{
    public function deduceType(callable $function): array;

    public function deduceReturnType(callable $function): string;
}
