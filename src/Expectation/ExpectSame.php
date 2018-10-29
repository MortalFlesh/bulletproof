<?php declare(strict_types=1);

namespace MF\Bulletproof\Expectation;

use MF\Bulletproof\Bulletproof;
use PHPUnit\Framework\Assert;

class ExpectSame implements ExpectationInterface
{
    /** @var mixed of the same type as a result */
    private $expected;

    public static function with($expected): self
    {
        return new self($expected);
    }

    public static function by(callable $expectation): self
    {
        return new self($expectation);
    }

    public function __construct($expected)
    {
        $this->expected = $expected;
    }

    public function __invoke($result, ...$parameters): void
    {
        $expected = is_callable($this->expected)
            ? call_user_func($this->expected, ...$parameters)
            : $this->expected;

        Assert::assertSame(
            $expected,
            $result,
            Bulletproof::createMessage($parameters, is_array($result) ? $result : [$result], 'are not same')
        );
    }
}
