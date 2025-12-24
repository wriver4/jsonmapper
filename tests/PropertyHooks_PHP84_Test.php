<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;

/**
 * Unit tests for JsonMapper's support for PHP 8.4 property hooks
 *
 * @category Tests
 * @package  JsonMapper
 * @author   JsonMapper Contributors
 * @license  OSL-3.0 http://opensource.org/licenses/osl-3.0
 * @link     https://github.com/cweiske/jsonmapper
 * @requires PHP 8.4
 */
class PropertyHooks_PHP84_Test extends TestCase
{
    /**
     * Test mapping to a class with property hooks (get/set)
     */
    public function testPropertyHooksMapping()
    {
        $json = json_decode('{"name": "JOHN", "age": 25}');
        $jsonMapper = new \JsonMapper();

        $result = $jsonMapper->map($json, new JsonMapperTest_PHP84PropertyHooks());

        $this->assertInstanceOf(JsonMapperTest_PHP84PropertyHooks::class, $result);
        // The set hook converts to lowercase, get hook capitalizes first letter
        $this->assertSame('John', $result->name);
        $this->assertSame(25, $result->age);
    }

    /**
     * Test that property hooks validation works
     */
    public function testPropertyHooksValidation()
    {
        $json = json_decode('{"name": "test", "age": -5}');
        $jsonMapper = new \JsonMapper();

        $this->expectException(ValueError::class);
        $this->expectExceptionMessage('Age cannot be negative');

        // This should trigger the validation in the age set hook
        $jsonMapper->map($json, new JsonMapperTest_PHP84PropertyHooks());
    }

    /**
     * Test that get hooks transform values correctly
     */
    public function testPropertyHooksGetTransformation()
    {
        $json = json_decode('{"name": "alice", "age": 30}');
        $jsonMapper = new \JsonMapper();

        $result = $jsonMapper->map($json, new JsonMapperTest_PHP84PropertyHooks());

        // Name should be stored as lowercase but returned with first letter capitalized
        $this->assertSame('Alice', $result->name);
        $this->assertNotSame('alice', $result->name);
    }
}
