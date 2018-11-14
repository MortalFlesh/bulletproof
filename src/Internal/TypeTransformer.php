<?php declare(strict_types=1);

namespace MF\Bulletproof\Internal;

use Eris\Generator;

class TypeTransformer
{
    /** @param Type[] $parameters */
    public function transformParametersToGenerators(array $parameters): iterable
    {
        foreach ($parameters as $parameter) {
            $types = $parameter->getTypes();
            $count = count($types);

            if ($count === 1) {
                yield $this->transformToGenerator(array_shift($types));
            } elseif ($count > 1) {
                yield Generator\oneOf(...array_map([$this, 'transformToGenerator'], $types));
            }
        }
    }

    private function transformToGenerator(string $type): Generator
    {
        switch ($type) {
            case 'null':
                return Generator\constant(null);
            case 'integer':
                return Generator\int();
            case 'string':
                return Generator\string();
            case 'boolean':
                return Generator\bool();
            case 'float':
                return Generator\float();
            default:
                throw new \Exception(sprintf('Method %s is not implemented for %s yet.', __METHOD__, $type));
        }
    }
}
