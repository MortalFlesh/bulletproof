<?php declare(strict_types=1);

namespace MF\Bulletproof\Internal;

use MF\Bulletproof\ClassInferenceInterface;

class ReflectionTypeGuesser implements ClassInferenceInterface
{
    public function deduceType(string $class, string $method): array
    {
        return array_map(
            function (\ReflectionParameter $parameter) {
                return $parameter->getType() === null
                    ? Type::fromStaticTypes('null')
                    : Type::fromReflectionType($parameter->getType());
            },
            $parameters = (new \ReflectionClass($class))
                ->getMethod($method)
                ->getParameters()
        );
    }

    public function deduceReturnType(string $class, string $method): Type
    {
        $returnType = (new \ReflectionClass($class))
            ->getMethod($method)
            ->getReturnType();

        return $returnType === null
            ? Type::fromStaticTypes('null')
            : Type::fromReflectionType($returnType);
    }
}
