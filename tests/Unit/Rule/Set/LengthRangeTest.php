<?php declare(strict_types=1);

namespace HarmonyIO\ValidationTest\Unit\Rule\Set;

use Generator;
use HarmonyIO\Validation\Exception\InvalidNumericalRange;
use HarmonyIO\Validation\Result\Result;
use HarmonyIO\Validation\Rule\Set\LengthRange;
use HarmonyIO\ValidationTest\Unit\Rule\CountableTestCase;

class LengthRangeTest extends CountableTestCase
{
    /**
     * LengthRangeTest constructor.
     *
     * @param string|null $name
     * @param array<mixed> $data
     * @param string $dataName
     */
    public function __construct(?string $name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName, LengthRange::class, 3, 4);
    }

    public function testConstructorThrowsWhenMinimumValueIsGreaterThanMaximumValue()
    {
        $this->expectException(InvalidNumericalRange::class);
        $this->expectExceptionMessage('The minimum (`51`) can not be greater than the maximum (`50`).');

        new LengthRange(51, 50);
    }

    public function testValidateFailsWhenPassingAnArrayWithLessItemsThanTheMinimum(): Generator
    {
        /** @var Result $result */
        $result = yield (new LengthRange(3, 4))->validate([]);

        $this->assertFalse($result->isValid());
        $this->assertSame('Set.MinimumLength', $result->getFirstError()->getMessage());
        $this->assertSame('length', $result->getFirstError()->getParameters()[0]->getKey());
        $this->assertSame(3, $result->getFirstError()->getParameters()[0]->getValue());
    }

    public function testValidateFailsWhenPassingAnArrayIteratorWithLessItemsThanTheMinimum(): Generator
    {
        /** @var Result $result */
        $result = yield (new LengthRange(3, 4))->validate(new \ArrayIterator(['foo', 'bar']));

        $this->assertFalse($result->isValid());
        $this->assertSame('Set.MinimumLength', $result->getFirstError()->getMessage());
        $this->assertSame('length', $result->getFirstError()->getParameters()[0]->getKey());
        $this->assertSame(3, $result->getFirstError()->getParameters()[0]->getValue());
    }

    public function testValidateFailsWhenPassingAnArrayWithMoreItemsThanTheMaximum(): Generator
    {
        /** @var Result $result */
        $result = yield (new LengthRange(3, 4))->validate(['foo', 'bar', 'baz', 'qux', 'quux']);

        $this->assertFalse($result->isValid());
        $this->assertSame('Set.MaximumLength', $result->getFirstError()->getMessage());
        $this->assertSame('length', $result->getFirstError()->getParameters()[0]->getKey());
        $this->assertSame(4, $result->getFirstError()->getParameters()[0]->getValue());
    }

    public function testValidateFailsWhenPassingAnArrayIteratorWithMoreItemsThanTheMaximum(): Generator
    {
        /** @var Result $result */
        $result = yield (new LengthRange(3, 4))->validate(new \ArrayIterator(['foo', 'bar', 'baz', 'qux', 'quux']));

        $this->assertFalse($result->isValid());
        $this->assertSame('Set.MaximumLength', $result->getFirstError()->getMessage());
        $this->assertSame('length', $result->getFirstError()->getParameters()[0]->getKey());
        $this->assertSame(4, $result->getFirstError()->getParameters()[0]->getValue());
    }

    public function testValidateSucceedsWhenPassingAnArrayWithExactNumberOfItemsAsTheMinimum(): Generator
    {
        /** @var Result $result */
        $result = yield (new LengthRange(3, 4))->validate(['foo', 'bar', 'baz']);

        $this->assertTrue($result->isValid());
        $this->assertNull($result->getFirstError());
    }

    public function testValidateSucceedsWhenPassingAnArrayIteratorWithExactNumberOfItemsAsTheMinimum(): Generator
    {
        /** @var Result $result */
        $result = yield (new LengthRange(3, 4))->validate(new \ArrayIterator(['foo', 'bar', 'baz']));

        $this->assertTrue($result->isValid());
        $this->assertNull($result->getFirstError());
    }

    public function testValidateSucceedsWhenPassingAnArrayWithExactNumberOfItemsAsTheMaximum(): Generator
    {
        /** @var Result $result */
        $result = yield (new LengthRange(3, 4))->validate(['foo', 'bar', 'baz', 'qux']);

        $this->assertTrue($result->isValid());
        $this->assertNull($result->getFirstError());
    }

    public function testValidateSucceedsWhenPassingAnArrayIteratorWithExactNumberOfItemsAsTheMaximum(): Generator
    {
        /** @var Result $result */
        $result = yield (new LengthRange(3, 4))->validate(new \ArrayIterator(['foo', 'bar', 'baz', 'qux']));

        $this->assertTrue($result->isValid());
        $this->assertNull($result->getFirstError());
    }

    public function testValidateSucceedsWhenPassingAnArrayWithNumberOfItemsInRange(): Generator
    {
        /** @var Result $result */
        $result = yield (new LengthRange(3, 5))->validate(['foo', 'bar', 'baz', 'qux']);

        $this->assertTrue($result->isValid());
        $this->assertNull($result->getFirstError());
    }

    public function testValidateSucceedsWhenPassingAnArrayIteratorWithNumberOfItemsInRange(): Generator
    {
        /** @var Result $result */
        $result = yield (new LengthRange(3, 5))->validate(new \ArrayIterator(['foo', 'bar', 'baz', 'qux']));

        $this->assertTrue($result->isValid());
        $this->assertNull($result->getFirstError());
    }
}
