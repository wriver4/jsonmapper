<?php

declare(strict_types=1);

class JsonMapperTest_PHP84AsymmetricVisibility
{
    // Public read, private write
    public private(set) string $username;

    // Public read, protected write
    public protected(set) int $userId;

    // Public read, private write with default
    public private(set) array $permissions = [];

    public function __construct()
    {
        $this->username = '';
        $this->userId = 0;
    }
}
