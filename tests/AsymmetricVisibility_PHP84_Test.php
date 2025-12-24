<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;

/**
 * Unit tests for JsonMapper's support for PHP 8.4 asymmetric visibility
 *
 * @category Tests
 * @package  JsonMapper
 * @author   JsonMapper Contributors
 * @license  OSL-3.0 http://opensource.org/licenses/osl-3.0
 * @link     https://github.com/cweiske/jsonmapper
 * @requires PHP 8.4
 */
class AsymmetricVisibility_PHP84_Test extends TestCase
{
    /**
     * Test mapping to a class with asymmetric visibility properties
     */
    public function testAsymmetricVisibilityMapping()
    {
        $json = json_decode('{"username": "john_doe", "userId": 12345, "permissions": ["read", "write"]}');
        $jsonMapper = new \JsonMapper();
        $jsonMapper->bIgnoreVisibility = true;

        $result = $jsonMapper->map($json, new JsonMapperTest_PHP84AsymmetricVisibility());

        $this->assertInstanceOf(JsonMapperTest_PHP84AsymmetricVisibility::class, $result);
        $this->assertSame('john_doe', $result->username);
        $this->assertSame(12345, $result->userId);
        $this->assertIsArray($result->permissions);
        $this->assertCount(2, $result->permissions);
    }

    /**
     * Test that asymmetric visibility properties can be read publicly
     */
    public function testAsymmetricVisibilityPublicRead()
    {
        $json = json_decode('{"username": "alice", "userId": 999, "permissions": ["admin"]}');
        $jsonMapper = new \JsonMapper();
        $jsonMapper->bIgnoreVisibility = true;

        $result = $jsonMapper->map($json, new JsonMapperTest_PHP84AsymmetricVisibility());

        // These should all be readable publicly
        $this->assertSame('alice', $result->username);
        $this->assertSame(999, $result->userId);
        $this->assertContains('admin', $result->permissions);
    }

    /**
     * Test mapping with missing optional properties
     */
    public function testAsymmetricVisibilityWithDefaults()
    {
        $json = json_decode('{"username": "bob", "userId": 500}');
        $jsonMapper = new \JsonMapper();
        $jsonMapper->bIgnoreVisibility = true;
        $jsonMapper->bExceptionOnMissingData = false;

        $result = $jsonMapper->map($json, new JsonMapperTest_PHP84AsymmetricVisibility());

        $this->assertSame('bob', $result->username);
        $this->assertSame(500, $result->userId);
        // permissions should have default empty array
        $this->assertIsArray($result->permissions);
        $this->assertEmpty($result->permissions);
    }
}
