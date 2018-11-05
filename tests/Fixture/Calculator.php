<?php declare(strict_types=1);

namespace MF\Bulletproof\Fixture;

class Calculator
{
    public function add(int $a, int $b): int
    {
        return $a + $b;
    }

    public function addWithBug(int $a, int $b): int
    {
        if ($a > 5) {
            $a++;
        }

        return $a + $b;
    }
}
