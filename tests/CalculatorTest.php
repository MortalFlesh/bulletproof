<?php declare(strict_types=1);

namespace MF\Bulletproof;

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

    public function testShouldAddIntegersAndReturnInteger(): void
    {
        $this->shouldBeBulletproof([$this->calculator, 'add']);
    }

    public function testShouldAddCorrectlyByGeneratedValues(): void
    {
        $this->shouldBeBulletproof(
            [$this->calculator, 'add'],
            [
                function (int $a, int $b): void {
                    $result = $this->calculator->add($a, $b);

                    $this->assertSame(
                        $a + $b,
                        $result,
                        $this->createMessage([$a, $b], [$result], 'are not same')
                    );
                },
            ]
        );
    }

    public function testShouldAddCorrectlyByGeneratedValuesButOnMethodWithBug(): void
    {
        $this->shouldBeBulletproof(
            [$this->calculator, 'add'],
            [
                function (int $a, int $b): void {
                    $result = $this->calculator->addWithBug($a, $b);

                    $this->assertSame(
                        $a + $b,
                        $result,
                        $this->createMessage([$a, $b], [$result], 'are not same')
                    );
                },
            ]
        );
    }
}
