<?php

namespace Sitnikovik\Test;

use Sitnikovik\FlexArray\FlexArray;
use PHPUnit\Framework\TestCase;

class FlexArrayTest extends TestCase
{
    /**
     * Initial haystack array
     *
     * @var array
     */
    protected static $haystack = [
        [0, 1, 2, 3, 5],
        'fruits' => ['apple', 'orange'],
        'persons' => [
            'john_doe' => [
                'name' => 'John Doe',
                'cars' => ['bmw', 'audi'],
                'isActive' => true,
                'comment' => 'some description',
            ],
            'mike_shepard' => [
                'name' => 'Mike Shepard',
                'cars' => [],
                'isActive' => false,
                'comment' => null
            ],
        ]
    ];

    /**
     * @var FlexArray
     */
    protected $flexArray;

    /**
     * @return void
     */
    public function setUp(): void
    {
        $this->flexArray = new FlexArray(static::$haystack);
    }

    /**
     * @return void
     */
    public function testHasAnyKey(): void
    {
        $this->assertTrue($this->flexArray->hasAnyKey('fruits', 1));
        $this->assertTrue($this->flexArray->hasAnyKey('fruits', 'persons'));
    }

    /**
     * @return void
     */
    public function testIndexOfKey(): void
    {
        $this->assertEquals(1, $this->flexArray->indexOfKey('fruits'));
        $this->assertNull($this->flexArray->indexOfKey(1));
    }

    /**
     * @return void
     */
    public function testHasValues(): void
    {
        $this->assertTrue($this->flexArray->hasValues(['apple', 'orange']));
        $this->assertFalse($this->flexArray->hasValues(['apple', 'orange'],'persons'));
        $this->assertFalse($this->flexArray->hasValues('0', ['apple', 'orange'], 'persons'));
    }

    /**
     * @return void
     */
    public function testCount(): void
    {
        $this->assertEquals(count(self::$haystack), $this->flexArray->count());
        $this->assertEquals(count(self::$haystack[0]), $this->flexArray->createByFirst()->count());
    }

    /**
     * @return void
     */
    public function testGetAllIntegers(): void
    {
        $this->assertEmpty($this->flexArray->getAllIntegers());
        $this->assertEquals(self::$haystack[0], $this->flexArray->getAllIntegers());
    }

    /**
     * @return void
     */
    public function testFlip(): void
    {
        $_array = array_flip(self::$haystack['fruits']);
        $this->assertEquals($_array, $this->flexArray->createBy('fruits')->flip()->getAll());
    }

    /**
     * @return void
     */
    public function testGetAllStrings(): void
    {
        $this->assertEquals([], $this->flexArray->getAllStrings());
        $this->assertEquals(
            self::$haystack['fruits'],
            $this->flexArray->createBy('fruits')->getAllStrings()
        );
    }

    /**
     * Tests that `getAll()` returns array provided on `setUp()`
     *
     * @return void
     */
    public function testGetAll(): void
    {
        $this->assertEquals($this->flexArray->getAll(), static::$haystack);
    }

    /**
     * @return void
     */
    public function testImplodeKeys(): void
    {
        $this->assertEquals("0,fruits,persons", $this->flexArray->implodeKeys(","));
    }

    /**
     * @return void
     */
    public function testGetLast(): void
    {
        $this->assertEquals(self::$haystack["persons"], $this->flexArray->getLast());
    }

    /**
     * @return void
     */
    public function testTouch(): void
    {
        $this->assertEquals([], $this->flexArray->touch());

        $this->assertEquals(
            array_merge([], [
                self::$haystack[0]],
                [ 'fruits' => self::$haystack['fruits'] ]
            ),
            $this->flexArray->touch(0, 'fruits', 'apples')
        );

        $this->assertEquals(
            [],
            $this->flexArray->createBy('persons')->createByLast()->touch('isActive', 'description')
        );
    }

    /**
     * @return void
     */
    public function testFindValues(): void
    {
        $this->assertEquals(
            [
                'fruits' => [
                    'apple',
                    'orange'
                ]
            ],
            $this->flexArray->findValues(['apple', 'orange'], 'apple', 'orange')
        );

        $this->assertEquals(
            ['isActive' => true],
            $this->flexArray
                ->createBy('persons')
                ->createByFirst()
                ->findValues(true)
        );

        $this->assertEquals(
            [],
            $this->flexArray->createBy('persons')->createByFirst()->findValues("true")
        );
    }

    /**
     * @return void
     */
    public function testGetAllBooleans(): void
    {
        $this->assertEquals(
            [],
            $this->flexArray->getAllBooleans()
        );

        $this->assertEquals(
            ['isActive' => true],
            $this->flexArray->createBy('persons')->createBy('john_doe')->getAllBooleans()
        );

        $this->assertEquals(
            ['isActive' => false],
            $this->flexArray->createBy('persons')->createBy('mike_shepard')->getAllBooleans()
        );
    }

    /**
     * @return void
     */
    public function testKeyOf(): void
    {
        $this->assertNull($this->flexArray->keyOf('fruits'));

        $this->assertEquals(
            "true",
            $this->flexArray->keyOf(['apple', 'orange'])
        );
    }

    public function testImplode()
    {

    }

    public function testInCount()
    {

    }

    public function testAppend()
    {

    }

    public function testDeleteLast()
    {

    }

    public function testGetKeys()
    {

    }

    public function testHasKeys()
    {

    }

    public function testGetFirstKey()
    {

    }

    public function testDeleteAll()
    {

    }

    public function testImplodeAll()
    {

    }

    public function testToJson()
    {

    }

    public function testGetFirst()
    {

    }

    public function testKrsort()
    {

    }

    public function testKsort()
    {

    }

    public function testGetByIndex()
    {

    }

    public function testGetLastKey()
    {

    }

    public function testCreateBy()
    {

    }

    public function testGetUpTo()
    {

    }

    public function testKeysOf()
    {

    }

    public function testDeleteOnFound()
    {

    }

    public function testMerge()
    {

    }

    public function testAssertEqualsByKey()
    {

    }

    public function testAssertAnyEqualsByKey()
    {

    }

    public function testBinarySearch()
    {

    }

    public function testIndexesOf()
    {

    }

    public function testGetAllNotEmpty()
    {

    }

    public function testPrepend()
    {

    }

    public function testKeyExists()
    {

    }

    public function testGetAllBut()
    {

    }

    public function testSet()
    {

    }

    public function testIsEmpty()
    {

    }

    /**
     * Tests that get() returns expected
     *
     * @return void
     */
    public function testGet(): void
    {
        $this->assertEquals($this->flexArray->get('fruits'), static::$haystack['fruits']);
    }

    public function testClean()
    {

    }

    public function testRsort()
    {

    }

    public function testAsort()
    {

    }

    public function testCreateByFirst()
    {

    }

    public function testHasAnyValue()
    {

    }

    public function testUnique()
    {

    }

    public function testDelete()
    {

    }

    public function testDeleteByIndex()
    {

    }

    public function testSort()
    {

    }

    public function testCreateByLast()
    {

    }

    public function testArsort()
    {

    }

    public function testCreateByIndex()
    {

    }

    public function testGetKeyOfIndex()
    {

    }

    public function testDeleteFirst()
    {

    }

    public function testIndexOf()
    {

    }
}
