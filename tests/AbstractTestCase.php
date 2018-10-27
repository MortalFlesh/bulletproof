<?php declare(strict_types=1);

namespace MF\Bulletproof;

use Eris\Generator;
use PHPUnit\Framework\TestCase;

abstract class AbstractTestCase extends TestCase
{
    use \Eris\TestTrait;

    /** @var TypeInferenceInterface */
    private $typeInference;

    protected function init(TypeInferenceInterface $typeInference): void
    {
        $this->typeInference = $typeInference;
    }

    public function shouldBeBulletProof($object, string $method, callable $additionalAssertion = null): void
    {
        $returnType = $this->typeInference->deduceReturnType($object, $method);

        $this
            ->forAll(...$this->getGeneratorsForParameters(get_class($object), $method))
            ->then(function (...$parameters) use ($additionalAssertion, $returnType, $method, $object): void {
                $result = $object->{$method}(...$parameters);

                $this->assertInternalType($returnType, $result);

                if ($additionalAssertion) {
                    $additionalAssertion($result, ...$parameters);
                }
            });
    }

    private function getGeneratorsForParameters(string $object, string $method): array
    {
        return array_map(
            function (string $type) {
                switch ($type) {
                    case 'int':
                        return Generator\int();
                    default:
                        throw new \Exception(sprintf('Method %s is not implemented yet.', __METHOD__));
                }
            },
            $this->typeInference->deduceType($object, $method)
        );
    }

    protected function createMessage(array $source, array $result, string $problemDescription = 'is wrong'): string
    {
        return sprintf(
            'This array [%s] %s. Result is [%s].',
            implode(', ', $source),
            $problemDescription,
            implode(', ', $result)
        );
    }
}
