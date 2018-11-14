<?php declare(strict_types=1);

namespace MF\Bulletproof\Internal;

class Normalizer
{
    public static function normalizeType(string $type): string
    {
        $type = mb_strtolower($type);

        // todo deal with `mixed`, objects, ... somehow

        switch ($type) {
            case 'bool':
                return 'boolean';
            case 'int':
                return 'integer';
            default:
                return $type;
        }
    }
}
