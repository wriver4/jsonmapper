<?php

declare(strict_types=1);

readonly class JsonMapperTest_PHP83ReadonlyClass
{
    public function __construct(
        public string $name,
        public int $age,
        public array $items
    ) {
    }
}
