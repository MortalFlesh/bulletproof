<?php declare(strict_types=1);

namespace MF\Bulletproof;

use MF\Bulletproof\Fixture\Calculator;

class CalculatorTest extends AbstractTestCase
{
    use \Eris\TestTrait;

    /** @var Calculator */
    private $calculator;

    protected function setUp(): void
    {
        $this->calculator = new Calculator();

        // this should be done by PHPStan
        $this->init(
            new class() implements TypeInferenceInterface {
                public function deduceType(string $object, string $method): array
                {
                    return ['int', 'int'];
                }

                public function deduceReturnType($object, string $method): string
                {
                    return 'int';
                }
            }
        );
    }

    public function testShouldAddCorrectly(): void
    {
        $this->assertSame(2, $this->calculator->add(1, 1));
    }

    public function testShouldAddIntegersAndReturnInteger(): void
    {
        $this->shouldBeBulletProof($this->calculator, 'add');
    }

    public function testShouldAddCorrectlyByGeneratedValues(): void
    {
        $this->shouldBeBulletProof(
            $this->calculator,
            'add',
            function (int $a, int $b): void {
                $result = $this->calculator->add($a, $b);

                $this->assertSame(
                    $a + $b,
                    $result,
                    $this->createMessage([$a, $b], [$result], 'are not same')
                );
            }
        );
    }

    public function testShouldAddCorrectlyByGeneratedValuesButOnMethodWithBug(): void
    {
        $this->shouldBeBulletProof(
            $this->calculator,
            'add',
            function (int $a, int $b): void {
                $result = $this->calculator->addWithBug($a, $b);

                $this->assertSame(
                    $a + $b,
                    $result,
                    $this->createMessage([$a, $b], [$result], 'are not same')
                );
            }
        );
    }
}
