<?php declare(strict_types=1);

namespace MF\Bulletproof\Expectation;

interface ExpectationInterface
{
    public function __invoke($result, ...$parameters): void;
}
