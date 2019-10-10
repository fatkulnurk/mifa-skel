<?php

declare(strict_types=1);

namespace Mifa\Routing\DataGenerator;

use function count;
use function implode;

class GroupPosBased extends RegexBasedAbstract
{
    /**
     * {@inheritdoc}
     */
    protected function getApproxChunkSize(): int
    {
        return 10;
    }

    /**
     * {@inheritdoc}
     */
    protected function processChunk(array $regexToRoutesMap): array
    {
        $routeMap = [];
        $regexes = [];
        $offset = 1;
        foreach ($regexToRoutesMap as $regex => $route) {
            $regexes[] = $regex;
            $routeMap[$offset] = [$route->handler, $route->variables];

            $offset += count($route->variables);
        }

        $regex = '~^(?:'.implode('|', $regexes).')$~';

        return ['regex' => $regex, 'routeMap' => $routeMap];
    }
}
