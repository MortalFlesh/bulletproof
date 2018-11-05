<?php declare(strict_types=1);

namespace MF\Bulletproof;

trait Vest
{
    /** @var Bulletproof */
    private $bulletproof;

    /**
     * @before
     */
    protected function initBulletproof(): void
    {
        $this->bulletproof = new Bulletproof(
            // this should be done by PHPStan
            new class() implements TypeInferenceInterface {
                public function deduceType(callable $function): array
                {
                    return ['int', 'int'];
                }

                public function deduceReturnType(callable $function): string
                {
                    return 'int';
                }
            }
        );
    }

    protected function shouldBeBulletproof(callable $function, array $expectations = []): void
    {
        $returnType = $this->bulletproof->deduceReturnType($function);

        $this
            ->forAll(...$this->bulletproof->getGeneratorsForParameters($function))
            ->then(function (...$parameters) use ($expectations, $returnType, $function): void {
                $result = $function(...$parameters);

                $this->assertInternalType($returnType, $result);

                foreach ($expectations as $expectation) {
                    $expectation($result, ...$parameters);
                }
            });
    }

    protected function createMessage(array $source, array $result, string $problemDescription = 'is wrong'): string
    {
        return Bulletproof::createMessage($source, $result, $problemDescription);
    }
}
