<?php declare(strict_types=1);

namespace MF\Bulletproof\Internal;

use function MF\Stringify\stringify;

class Formatter
{
    public static function createMessage(array $source, array $result, string $problemDescription): string
    {
        return sprintf(
            'This array %s %s. Result is %s.',
            stringify($source),
            $problemDescription,
            stringify($result)
        );
    }
}
