<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;

/**
 * Unit tests for JsonMapper's support for PHP 8.3 readonly classes
 *
 * @category Tests
 * @package  JsonMapper
 * @author   JsonMapper Contributors
 * @license  OSL-3.0 http://opensource.org/licenses/osl-3.0
 * @link     https://github.com/cweiske/jsonmapper
 * @requires PHP 8.3
 */
class ReadonlyClass_PHP83_Test extends TestCase
{
    /**
     * Test mapping to a readonly class with constructor property promotion
     */
    public function testReadonlyClassMapping()
    {
        $json = json_decode('{"name": "John Doe", "age": 30, "items": ["item1", "item2"]}');
        $jsonMapper = new \JsonMapper();
        $jsonMapper->bIgnoreVisibility = true;

        $result = $jsonMapper->map($json, JsonMapperTest_PHP83ReadonlyClass::class);

        $this->assertInstanceOf(JsonMapperTest_PHP83ReadonlyClass::class, $result);
        $this->assertSame('John Doe', $result->name);
        $this->assertSame(30, $result->age);
        $this->assertIsArray($result->items);
        $this->assertCount(2, $result->items);
        $this->assertSame('item1', $result->items[0]);
        $this->assertSame('item2', $result->items[1]);
    }

    /**
     * Test that readonly class properties cannot be modified after construction
     */
    public function testReadonlyClassImmutability()
    {
        $json = json_decode('{"name": "Jane Smith", "age": 25, "items": []}');
        $jsonMapper = new \JsonMapper();
        $jsonMapper->bIgnoreVisibility = true;

        $result = $jsonMapper->map($json, JsonMapperTest_PHP83ReadonlyClass::class);

        $this->expectException(Error::class);
        $this->expectExceptionMessage('Cannot modify readonly property');

        // This should throw an error
        $result->name = 'Different Name';
    }
}
