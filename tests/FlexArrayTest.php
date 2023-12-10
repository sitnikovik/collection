<?php

namespace Sitnikovik\Test;

use Exception;
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
        $this->assertEquals(
            1,
            $this->flexArray->indexOfKey('fruits')
        );

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
        $this->assertEquals(
            count(self::$haystack),
            $this->flexArray->count()
        );

        $this->assertEquals(
            count(self::$haystack[0]),
            $this->flexArray->createByFirst()->count()
        );
    }

    /**
     * @return void
     */
    public function testGetAllIntegers(): void
    {
        $this->assertEmpty($this->flexArray->getAllIntegers());

        $this->assertEquals(
            self::$haystack[0],
            $this->flexArray->createByFirst()->getAllIntegers()
        );
    }

    /**
     * @return void
     */
    public function testFlip(): void
    {
        $array = array_flip(self::$haystack['fruits']);

        $this->assertEquals(
            $array,
            $this->flexArray->createBy('fruits')->flip()->getAll()
        );
    }

    /**
     * @return void
     */
    public function testGetAllStrings(): void
    {
        $this->assertEquals(
            [],
            $this->flexArray->getAllStrings()
        );

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
        $this->assertEquals(
            static::$haystack,
            $this->flexArray->getAll()
        );
    }

    /**
     * @return void
     */
    public function testImplodeKeys(): void
    {
        $this->assertEquals(
            "0,fruits,persons",
            $this->flexArray->implodeKeys(",")
        );
    }

    /**
     * @return void
     */
    public function testGetLast(): void
    {
        $this->assertEquals(
            self::$haystack["persons"],
            $this->flexArray->getLast()
        );
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
            "fruits",
            $this->flexArray->keyOf(['apple', 'orange'])
        );
    }

    /**
     * @return void
     */
    public function testImplode(): void
    {
        $this->assertEquals(
            "",
            $this->flexArray->implode(',')
        );

        $this->assertEquals(
            "",
            $this->flexArray->implode(',', true)
        );

        $this->assertEquals(
            "name: John Doe,isActive: 1,comment: some description",
            $this->flexArray
                ->createBy('persons')
                ->createByFirst()
                ->implode(',', true)
        );

        $this->assertEquals(
            "name: Mike Shepard,isActive: ",
            $this->flexArray
                ->createBy('persons')
                ->createByLast()
                ->implode(',', true)
        );
    }

    /**
     * @return void
     */
    public function testInCount(): void
    {
        $this->assertTrue($this->flexArray->inCount(1));

        $this->assertTrue($this->flexArray->inCount(3));

        $this->assertFalse($this->flexArray->inCount(4));
        
        $this->assertTrue($this->flexArray->inCount(-1));
    }

    /**
     * @return void
     */
    public function testAppend(): void
    {
        $this->assertEquals(
            array_merge([], self::$haystack, ['apple']),
            $this->flexArray->append('apple')->getAll()
        );
    }

    /**
     * @return void
     */
    public function testDeleteLast(): void
    {
        $array = self::$haystack;
        unset($array['persons']);

        $this->assertEquals(
            $array,
            $this->flexArray->deleteLast()->getAll()
        );
    }

    /**
     * @return void
     */
    public function testGetKeys(): void
    {
        $this->assertEquals(
            array_keys(self::$haystack),
            $this->flexArray->getKeys()
        );
    }

    /**
     * @return void
     */
    public function testHasKeys(): void
    {
        $this->assertFalse($this->flexArray->hasKeys('fruits', 1));

        $this->assertTrue($this->flexArray->hasKeys('fruits', 'persons'));

        $this->assertFalse($this->flexArray->hasKeys('fruits', 1, 'persons'));

    }

    /**
     * @return void
     */
    public function testGetFirstKey(): void
    {
        $this->assertEquals(0, $this->flexArray->getFirstKey());

        $this->assertEquals(
            'john_doe',
            $this->flexArray->createBy('persons')->getFirstKey()
        );
    }

    /**
     * @return void
     */
    public function testDeleteAll(): void
    {
        $this->assertEquals([], $this->flexArray->deleteAll()->getAll());
    }

    /**
     * @return void
     */
    public function testImplodeAll(): void
    {
        $this->assertEquals(
            "0,1,2,3,5,apple,orange,John Doe,bmw,audi,1,some description,Mike Shepard,,",
            $this->flexArray->implodeAll(',')
        );
    }

    /**
     * @return void
     * @throws Exception
     */
    public function testToJson(): void
    {
        $this->assertEquals(
            json_encode(self::$haystack, JSON_THROW_ON_ERROR),
            $this->flexArray->toJson()
        );
    }

    /**
     * @return void
     */
    public function testGetFirst(): void
    {
        $this->assertEquals(
            self::$haystack[0],
            $this->flexArray->getFirst()
        );

        $this->assertEquals(
            self::$haystack['persons']['john_doe'],
            $this->flexArray->createBy('persons')->getFirst()
        );

    }

    /**
     * @return void
     */
    public function testKrsort(): void
    {
        $array = self::$haystack;
        krsort($array);

        $this->assertEquals(
            $array,
            $this->flexArray->krsort()->getAll()
        );
    }

    /**
     * @return void
     */
    public function testKsort(): void
    {
        $array = self::$haystack;
        ksort($array);

        $this->assertEquals(
            $array,
            $this->flexArray->krsort()->getAll()
        );
    }

    /**
     * @return void
     */
    public function testGetByIndex(): void
    {
        $this->assertEquals(
            self::$haystack[0],
            $this->flexArray->getByIndex(0)
        );

        $this->assertEquals(
            self::$haystack['persons'],
            $this->flexArray->getByIndex(2)
        );

        $this->assertEquals(
            null,
            $this->flexArray->getByIndex(7)
        );

        $this->assertEquals(
            "apple",
            $this->flexArray->createBy('fruits')->getByIndex(0)
        );

        $this->assertEquals(
            null,
            $this->flexArray->createBy('fruits')->getByIndex(3)
        );
    }

    /**
     * @return void
     */
    public function testGetLastKey(): void
    {
        $this->assertEquals(
            "persons",
            $this->flexArray->getLastKey()
        );

        $this->assertEquals(
            "mike_shepard",
            $this->flexArray->createBy('persons')->getLastKey()
        );
    }

    /**
     * @return void
     */
    public function testCreateBy(): void
    {
        $_flex = new FlexArray(self::$haystack['persons']);

        $this->assertEquals(
            $_flex->getAll(),
            $this->flexArray->createBy('persons')->getAll()
        );

        $this->assertEquals(
            [],
            $this->flexArray->createBy('john_doe')->getAll()
        );
    }

    /**
     * @return void
     */
    public function testGetUpTo(): void
    {
        $this->assertEquals(
            self::$haystack,
            $this->flexArray->getUpTo(2)
        );
    }

    /**
     * @return void
     */
    public function testKeysOf(): void
    {
        $this->assertEquals(
            [],
            $this->flexArray->keysOf('fruits')
        );
    }

    /**
     * @return void
     */
    public function testDeleteOnFound(): void
    {
        $array = self::$haystack;
        unset($array['fruits']);

        $this->assertEquals(
            $array,
            $this->flexArray->deleteOnFound(['apple', 'orange'])->getAll()
        );

        $this->assertEquals(
            $array,
            $this->flexArray->deleteOnFound('apple')->getAll()
        );
    }

    /**
     * @return void
     */
    public function testMerge(): void
    {
        $array = array_merge(self::$haystack, ['cars' => ['bmw', 'audi']]);

        $this->assertEquals(
            $array,
            $this->flexArray->merge([
                'cars' => ['bmw', 'audi']
            ])->getAll()
        );
    }

    /**
     * @return void
     */
    public function testAssertEqualsByKey(): void
    {
        $this->assertTrue($this->flexArray->assertEqualsByKey('fruits', ['apple', 'orange']));

        $this->assertFalse($this->flexArray->assertEqualsByKey( 0, ['apple', 'orange']));

        $this->assertTrue($this->flexArray->assertEqualsByKey('apple', null));

    }

    /**
     * @return void
     */
    public function testAssertAnyEqualsByKey(): void
    {
        $this->assertTrue($this->flexArray->assertAnyEqualsByKey('fruits', ['apple'], ['apple', 'orange']));

        $this->assertFalse($this->flexArray->assertAnyEqualsByKey( 'fruits', ['apple'], ['apple', 'oranges']));
    }

    /**
     * @return void
     */
    public function testBinarySearch(): void
    {
        $this->assertNull($this->flexArray->binarySearch(0));

        $this->assertEquals(
            3,
            $this->flexArray->createByFirst()->binarySearch(3)
        );

        $this->assertEquals(
            4,
            $this->flexArray->createByFirst()->binarySearch(5)
        );
    }

    /**
     * @return void
     */
    public function testIndexesOf(): void
    {
        $this->assertEmpty($this->flexArray->indexesOf('fruits'));

        $this->assertEquals(
            [1],
            $this->flexArray->indexesOf(['apple', 'orange'])
        );
    }

    /**
     * @return void
     */
    public function testGetAllNotEmpty(): void
    {
        $this->assertEquals(
            self::$haystack,
            $this->flexArray->getAllNotEmpty()
        );

        $this->assertNotEquals(
            self::$haystack['persons']['mike_shepard'],
            $this->flexArray
                ->createBy('persons')
                ->createBy('mike_shepard')
                ->getAllNotEmpty()
        );

        $this->assertEquals(
            self::$haystack['persons']['john_doe'],
            $this->flexArray
                ->createBy('persons')
                ->createBy('john_doe')
                ->getAllNotEmpty()
        );
    }

    /**
     * @return void
     */
    public function testPrepend(): void
    {
        $this->assertEquals(
            array_merge([], ['apple'], self::$haystack),
            $this->flexArray->prepend('apple')->getAll()
        );
    }

    /**
     * @return void
     */
    public function testKeyExists(): void
    {
        $this->assertTrue($this->flexArray->keyExists('fruits'));

        $this->assertFalse($this->flexArray->keyExists(1));

        $this->assertTrue(
            $this->flexArray
                ->createBy('persons')
                ->createBy('mike_shepard')
                ->keyExists('comment')
        );

        $this->assertTrue(
            $this->flexArray
                ->createBy('persons')
                ->createBy('mike_shepard')
                ->keyExists('isActive')
        );

    }

    /**
     * @return void
     */
    public function testGetAllBut(): void
    {
        $this->assertEquals(
            array_merge(
                [],
                [self::$haystack[0]],
                ['fruits' => self::$haystack['fruits']]
            ),
            $this->flexArray->getAllBut('persons')
        );
    }

    /**
     * @return void
     */
    public function testSet(): void
    {
        $this->flexArray->set('fruits', 'apple');

        $this->assertEquals(
            "apple",
            $this->flexArray->get('fruits')
        );
    }

    /**
     * @return void
     */
    public function testIsEmpty(): void
    {
        $this->assertFalse($this->flexArray->isEmpty('fruits'));

        $this->assertTrue($this->flexArray->isEmpty(1));

        $this->assertTrue(
            $this->flexArray
                ->createBy('persons')
                ->createBy('mike_shepard')
                ->isEmpty('comment')
        );

        $this->assertTrue(
            $this->flexArray
                ->createBy('persons')
                ->createBy('mike_shepard')
                ->isEmpty('isActive')
        );
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

    /**
     * @return void
     */
    public function testClean(): void
    {
        $this->assertEquals(
            self::$haystack,
            $this->flexArray->clean()->getAll()
        );

        $this->assertEquals(
            [0, 1, 2, 3, 5],
            $this->flexArray->createByFirst()->clean()->getAll()
        );

        $this->assertEquals(
            ['name' => 'Mike Shepard'],
            $this->flexArray->createBy('persons')->createBy('mike_shepard')->clean()->getAll()
        );
    }

    /**
     * @return void
     */
    public function testRsort(): void
    {
        $array = self::$haystack;
        rsort($array);

        $this->assertEquals(
            $array,
            $this->flexArray->rsort()->getAll()
        );
    }

    /**
     * @return void
     */
    public function testAsort(): void
    {
        $array = self::$haystack;
        asort($array);

        $this->assertEquals(
            $array,
            $this->flexArray->asort()->getAll()
        );
    }

    /**
     * @return void
     */
    public function testCreateByFirst(): void
    {
        $flex = new FlexArray(self::$haystack[0]);

        $this->assertEquals(
            $flex->getAll(),
            $this->flexArray->createByFirst()->getAll()
        );
    }

    /**
     * @return void
     */
    public function testHasAnyValue(): void
    {
        $this->assertTrue($this->flexArray->hasAnyValue(['apple', 'orange']));

        $this->assertTrue($this->flexArray->hasAnyValue(['apple', 'orange'], 'persons'));

        $this->assertTrue($this->flexArray->hasAnyValue('0', ['apple', 'orange'], 'persons'));

        $this->assertFalse($this->flexArray->hasAnyValue(['apple', 'oranges'], 'persons'));

    }

    /**
     * @return void
     */
    public function testUnique(): void
    {
        $array = array_unique(self::$haystack[0]);

        $this->assertEquals(
            $array,
            $this->flexArray->createByFirst()->unique()->getAll()
        );
    }

    /**
     * @return void
     */
    public function testDelete(): void
    {
        $array = self::$haystack;
        unset($array['fruits']);

        $this->assertEquals(
            $array,
            $this->flexArray->delete('fruits')->getAll()
        );
    }

    /**
     * @return void
     */
    public function testDeleteByIndex(): void
    {
        $array = self::$haystack;
        unset($array[0]);

        $this->assertEquals(
            $array,
            $this->flexArray->deleteByIndex(0)->getAll()
        );

        $this->assertEquals(
            $array,
            $this->flexArray->deleteByIndex(123)->getAll()
        );
    }

    /**
     * @return void
     */
    public function testSort(): void
    {
        $array = self::$haystack;
        sort($array);

        $this->assertEquals(
            $array,
            $this->flexArray->sort()->getAll()
        );
    }

    /**
     * @return void
     */
    public function testCreateByLast(): void
    {
        $flex = new FlexArray(self::$haystack['persons']);

        $this->assertEquals(
            $flex->getAll(),
            $this->flexArray->createByLast()->getAll()
        );
    }

    /**
     * @return void
     */
    public function testArsort(): void
    {
        $array = self::$haystack;
        arsort($array);

        $this->assertEquals(
            $array,
            $this->flexArray->arsort()->getAll()
        );
    }

    /**
     * @return void
     */
    public function testCreateByIndex(): void
    {
        $flex = new FlexArray(self::$haystack['fruits']);

        $this->assertEquals(
            $flex->getAll(),
            $this->flexArray->createByIndex(1)->getAll()
        );
    }

    /**
     * @return void
     */
    public function testGetKeyOfIndex(): void
    {
        $this->assertEquals(
            0,
            $this->flexArray->getKeyOfIndex(0)
        );

        $this->assertEquals(
            'fruits',
            $this->flexArray->getKeyOfIndex(1)
        );

        $this->assertNull($this->flexArray->getKeyOfIndex(23));
    }

    /**
     * @return void
     */
    public function testDeleteFirst(): void
    {
        $array = self::$haystack;
        unset($array[0]);

        $this->assertEquals(
            $array,
            $this->flexArray->deleteFirst()->getAll()
        );
    }

    /**
     * @return void
     */
    public function testIndexOf(): void
    {
        $this->assertNull($this->flexArray->indexOf('fruits'));

        $this->assertEquals(
            1,
            $this->flexArray->indexOf(['apple', 'orange'])
        );
    }

    /**
     * @return void
     */
    public function testGetAny(): void
    {
        $haystack = [
            "one" => "one",
            "two" => "two",
            "three" => "three",
        ];
        $flex = new FlexArray($haystack);

        $this->assertNotNull($flex->getAny("One", "onE", "one"));
        $this->assertEquals($haystack["two"], $flex->getAny("two", "three", "one"));
        $this->assertEquals($haystack["three"], $flex->getAny("threE", "Two", "three", "one"));
    }

    /**
     * @return void
     */
    public function testGetInteger(): void
    {
        $haystack = [
            "0",
            "2",
            "1asd",
            "asd1",
            null,
        ];
        $flex = new FlexArray($haystack);

        $this->assertEquals(0, $flex->getInteger(0));
        $this->assertEquals(2, $flex->getInteger(1));
        $this->assertEquals(1, $flex->getInteger(2));
        $this->assertEquals(0, $flex->getInteger(3));
        $this->assertNull($flex->getInteger(5));
        $this->assertEquals(123, $flex->getFloat(5, 123));
    }

    /**
     * @return void
     */
    public function testGetFloat(): void
    {
        $haystack = [
            "0",
            "2",
            "1asd",
            "asd1",
            "2.1",
            null,
        ];
        $flex = new FlexArray($haystack);

        $this->assertEquals(0.0, $flex->getFloat(0));
        $this->assertEquals(2.0, $flex->getFloat(1));
        $this->assertEquals(1.0, $flex->getFloat(2));
        $this->assertEquals(0.0, $flex->getFloat(3));
        $this->assertEquals(2.1, $flex->getFloat(4));
        $this->assertNull($flex->getFloat(5));
        $this->assertEquals(123.0, $flex->getFloat(5, 123.0));
    }

    /**
     * @return void
     */
    public function testGetString(): void
    {
        $haystack = [
            0,
            "1",
            null,
            true,
            false,
        ];
        $flex = new FlexArray($haystack);

        $this->assertEquals("0", $flex->getString(0));
        $this->assertEquals("1", $flex->getString(1));
        $this->assertNull($flex->getString(2));
        $this->assertEquals("nullFound", $flex->getString(2, "nullFound"));
        $this->assertEquals("1", $flex->getString(3));
        $this->assertEquals("", $flex->getString(4));
    }

    /**
     * @return void
     */
    public function testGetBoolean(): void
    {
        $haystack = [
            0,
            "1",
            null,
            true,
            false,
        ];
        $flex = new FlexArray($haystack);

        $this->assertFalse($flex->getBoolean(0));
        $this->assertTrue($flex->getBoolean(1));
        $this->assertNull($flex->getBoolean(2));
        $this->assertFalse($flex->getBoolean(2, false));
        $this->assertTrue($flex->getBoolean(3));
        $this->assertFalse($flex->getBoolean(4));
    }
}
