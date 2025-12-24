<?php

/**
 * Unit tests for JsonMapper's class existence validation
 *
 * @category Tests
 * @package  JsonMapper
 * @author   JsonMapper Contributors
 * @license  OSL-3.0 http://opensource.org/licenses/osl-3.0
 * @link     https://github.com/cweiske/jsonmapper
 */
class ClassExistenceTest extends \PHPUnit\Framework\TestCase
{
    /**
     * Test that mapping to a non-existent class throws proper exception
     */
    public function testMapToNonExistentClass()
    {
        $this->expectException(JsonMapper_Exception::class);
        $this->expectExceptionMessage('Class or interface "NonExistentClass" used at property');

        $jm = new JsonMapper();
        $json = json_decode('{"simple": {"str": "test"}}');

        // Create a test object with a property that references a non-existent class
        $testObj = new class {
            /**
             * @var NonExistentClass
             */
            public $simple;
        };

        $jm->map($json, $testObj);
    }

    /**
     * Test that mapping to a non-existent class in array throws proper exception
     */
    public function testMapArrayToNonExistentClass()
    {
        $this->expectException(JsonMapper_Exception::class);
        $this->expectExceptionMessage('Class or interface "MissingClass" used at property');

        $jm = new JsonMapper();
        $json = json_decode('{"items": [{"name": "test"}]}');

        $testObj = new class {
            /**
             * @var MissingClass[]
             */
            public $items;
        };

        $jm->map($json, $testObj);
    }

    /**
     * Test that mapping with typo in class name gives clear error
     */
    public function testMapWithTypoInClassName()
    {
        $this->expectException(JsonMapper_Exception::class);
        $this->expectExceptionMessage('Class or interface "JsonMapperTest_Simpel" used at property');

        $jm = new JsonMapper();
        $json = json_decode('{"data": {"str": "value"}}');

        $testObj = new class {
            /**
             * @var JsonMapperTest_Simpel Note the typo: Simpel instead of Simple
             */
            public $data;
        };

        $jm->map($json, $testObj);
    }

    /**
     * Test that valid class names work correctly
     */
    public function testMapWithValidClassName()
    {
        $jm = new JsonMapper();
        $json = json_decode('{"data": {"str": "test value"}}');

        $testObj = new class {
            /**
             * @var JsonMapperTest_Simple
             */
            public $data;
        };

        $result = $jm->map($json, $testObj);

        $this->assertInstanceOf(JsonMapperTest_Simple::class, $result->data);
        $this->assertSame('test value', $result->data->str);
    }

    /**
     * Test that nullable non-existent class types throw proper exception
     */
    public function testMapNullableNonExistentClass()
    {
        $this->expectException(JsonMapper_Exception::class);
        $this->expectExceptionMessage('Class or interface "FakeClass" used at property');

        $jm = new JsonMapper();
        $json = json_decode('{"nullable": {"value": "test"}}');

        $testObj = new class {
            /**
             * @var ?FakeClass
             */
            public $nullable;
        };

        $jm->map($json, $testObj);
    }
}
