<?php declare(strict_types=1);

namespace MF\Bulletproof;

use MF\Bulletproof\Internal\Formatter;
use MF\Bulletproof\Internal\ReflectionTypeGuesser;
use MF\Bulletproof\Internal\Type;
use MF\Bulletproof\Internal\TypeTransformer;
use function MF\Stringify\stringify;

trait Vest
{
    /** @var TypeTransformer */
    private $typeTransformer;
    /** @var CallableInferenceInterface */
    private $callableInference;
    /** @var ClassInferenceInterface */
    private $classInference;

    /**
     * @before
     */
    protected function initBulletproof(): void
    {
        $this->typeTransformer = new TypeTransformer();

        // todo implement dynamic callable inference
        $this->callableInference = new class() implements CallableInferenceInterface {
            public function deduceType(callable $function): array
            {
                return [
                    Type::fromStaticTypes('int'),
                    Type::fromStaticTypes('int'),
                ];
            }

            public function deduceReturnType(callable $function): Type
            {
                return Type::fromStaticTypes('int');
            }
        };

        $this->classInference = new ReflectionTypeGuesser();
    }

    /**
     * @param object $object
     */
    protected function methodShouldBeBulletproof(
        $object,
        string $method,
        array $expectations = [],
        int $iterations = 100
    ): void {
        $class = get_class($object);
        $function = [$object, $method];

        if (is_callable($function)) {
            $this->shouldBeBulletproof(
                $function,
                $this->classInference->deduceType($class, $method),
                $this->classInference->deduceReturnType($class, $method),
                $expectations,
                $iterations
            );
        } else {
            throw new \InvalidArgumentException(
                sprintf('Given object method of %s combination is invalid.', stringify($function))
            );
        }
    }

    protected function callableShouldBeBulletproof(
        callable $function,
        array $expectations = [],
        int $iterations = 100
    ): void {
        $this->shouldBeBulletproof(
            $function,
            $this->callableInference->deduceType($function),
            $this->callableInference->deduceReturnType($function),
            $expectations,
            $iterations
        );
    }

    /** @param Type[] $parameterTypes */
    private function shouldBeBulletproof(
        callable $function,
        array $parameterTypes,
        Type $returnType,
        array $expectations,
        int $iterations
    ): void {
        $this
            ->limitTo($iterations)
            ->forAll(...$this->typeTransformer->transformParametersToGenerators($parameterTypes))
            ->then(function (...$parameters) use ($expectations, $returnType, $function): void {
                $result = $function(...$parameters);

                $type = gettype($result);
                $this->assertContains(
                    $type,
                    $returnType->getTypes(),
                    sprintf('%s is not in [%s]', $type, implode(', ', $returnType->getTypes()))
                );

                foreach ($expectations as $expectation) {
                    $expectation($result, ...$parameters);
                }
            });
    }

    protected function createMessage(array $source, array $result, string $problemDescription = 'is wrong'): string
    {
        return Formatter::createMessage($source, $result, $problemDescription);
    }
}
