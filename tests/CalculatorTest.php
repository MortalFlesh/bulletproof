<?php declare(strict_types=1);

namespace MF\Bulletproof;

use MF\Bulletproof\Expectation\ExpectSame;
use MF\Bulletproof\Fixture\Calculator;

class CalculatorTest extends AbstractTestCase
{
    use \Eris\TestTrait;
    use \MF\Bulletproof\Vest;

    /** @var Calculator */
    private $calculator;

    protected function setUp(): void
    {
        $this->calculator = new Calculator();
    }

    public function testShouldAddCorrectly(): void
    {
        $this->assertSame(2, $this->calculator->add(1, 1));
    }

    public function testShouldAddIntegersAndReturnInteger_byNaiveInference(): void
    {
        $this->callableShouldBeBulletproof([$this->calculator, 'add']);
    }

    public function testShouldAddCorrectlyByGeneratedValues_byNaiveInference(): void
    {
        $this->callableShouldBeBulletproof(
            [$this->calculator, 'add'],
            [
                ExpectSame::by(function (int $a, int $b) {
                    return $a + $b;
                }),
            ]
        );
    }

    public function testShouldAddCorrectlyByGeneratedValuesButOnMethodWithBug_byNaiveInference(): void
    {
        $this->callableShouldBeBulletproof(
            [$this->calculator, 'addWithBug'],
            [
                ExpectSame::by(function (int $a, int $b) {
                    return $a + $b;
                }),
            ]
        );
    }

    public function testShouldAddIntegersAndReturnInteger_byClassInference(): void
    {
        $this->methodShouldBeBulletproof($this->calculator, 'add');
    }

    public function testShouldAddCorrectlyByGeneratedValues_byClassInference(): void
    {
        $this->methodShouldBeBulletproof(
            $this->calculator,
            'add',
            [
                ExpectSame::by(function (int $a, int $b) {
                    return $a + $b;
                }),
            ]
        );
    }

    public function testShouldAddCorrectlyByGeneratedValuesButOnMethodWithBug_byClassInference(): void
    {
        $this->methodShouldBeBulletproof(
            $this->calculator,
            'addWithBug',
            [
                ExpectSame::by(function (int $a, int $b) {
                    return $a + $b;
                }),
            ]
        );
    }
}
