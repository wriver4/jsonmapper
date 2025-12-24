<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;

/**
 * Unit tests for JsonMapper with PHP 8.3 typed class constants
 *
 * @category Tests
 * @package  JsonMapper
 * @author   JsonMapper Contributors
 * @license  OSL-3.0 http://opensource.org/licenses/osl-3.0
 * @link     https://github.com/cweiske/jsonmapper
 * @requires PHP 8.3
 */
class TypedConstants_PHP83_Test extends TestCase
{
    /**
     * Test that classes with typed constants can be mapped correctly
     */
    public function testTypedConstantsClassMapping()
    {
        $json = json_decode('{"name": "test value", "value": 42}');
        $jsonMapper = new \JsonMapper();

        $result = $jsonMapper->map($json, new JsonMapperTest_PHP83TypedConstants());

        $this->assertInstanceOf(JsonMapperTest_PHP83TypedConstants::class, $result);
        $this->assertSame('test value', $result->name);
        $this->assertSame(42, $result->value);
    }

    /**
     * Test that typed constants retain their correct types
     */
    public function testTypedConstantTypes()
    {
        $this->assertSame('test', JsonMapperTest_PHP83TypedConstants::TYPE);
        $this->assertSame(100, JsonMapperTest_PHP83TypedConstants::MAX_SIZE);
        $this->assertIsString(JsonMapperTest_PHP83TypedConstants::TYPE);
        $this->assertIsInt(JsonMapperTest_PHP83TypedConstants::MAX_SIZE);
    }
}
