<?php declare(strict_types=1);

namespace MF\Bulletproof;

use Eris\Generator;

class Bulletproof
{
    /** @var TypeInferenceInterface */
    private $typeInference;

    public function __construct(TypeInferenceInterface $typeInference)
    {
        $this->typeInference = $typeInference;
    }

    public function getGeneratorsForParameters(callable $function): array
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
            $this->typeInference->deduceType($function)
        );
    }

    public function deduceReturnType(callable $function): string
    {
        return $this->typeInference->deduceReturnType($function);
    }
}
