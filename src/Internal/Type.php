<?php declare(strict_types=1);

namespace MF\Bulletproof\Internal;

class Type
{
    /** @var \ReflectionType|null */
    private $reflectionType;
    /** @var string[] */
    private $types = [];

    private function __construct()
    {
    }

    public static function fromStaticTypes(string ...$staticType): self
    {
        $type = new self();
        $type->types = $staticType;

        return $type;
    }

    public static function fromReflectionType(\ReflectionType $reflectionType): self
    {
        $type = new self();
        $type->reflectionType = $reflectionType;

        return $type;
    }

    public function getTypes(): array
    {
        return $this->normalize($this->getAllTypes());
    }

    private function normalize(array $types): array
    {
        return array_map([Normalizer::class, 'normalizeType'], $types);
    }

    private function getAllTypes(): array
    {
        if ($this->reflectionType !== null) {
            $types = [$this->reflectionType->getName()];

            if ($this->reflectionType->allowsNull()) {
                $types[] = 'null';
            }

            return $types;
        }

        return $this->types;
    }
}
