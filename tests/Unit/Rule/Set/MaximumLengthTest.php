<?php declare(strict_types=1);

namespace HarmonyIO\ValidationTest\Unit\Rule\Set;

use Generator;
use HarmonyIO\Validation\Result\Result;
use HarmonyIO\Validation\Rule\Set\MaximumLength;
use HarmonyIO\ValidationTest\Unit\Rule\CountableTestCase;

class MaximumLengthTest extends CountableTestCase
{
    /**
     * MaximumLengthTest constructor.
     *
     * @param string|null $name
     * @param array<mixed> $data
     * @param string $dataName
     */
    public function __construct(?string $name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName, MaximumLength::class, 3);
    }

    public function testValidateFailsWhenPassingAnArrayWithMoreItemsThanTheMaximum(): Generator
    {
        /** @var Result $result */
        $result = yield (new MaximumLength(3))->validate(['foo', 'bar', 'baz', 'qux']);

        $this->assertFalse($result->isValid());
        $this->assertSame('Set.MaximumLength', $result->getFirstError()->getMessage());
        $this->assertSame('length', $result->getFirstError()->getParameters()[0]->getKey());
        $this->assertSame(3, $result->getFirstError()->getParameters()[0]->getValue());
    }

    public function testValidateFailsWhenPassingAnArrayIteratorWithMoreItemsThanTheMaximum(): Generator
    {
        /** @var Result $result */
        $result = yield (new MaximumLength(3))->validate(new \ArrayIterator(['foo', 'bar', 'baz', 'qux']));

        $this->assertFalse($result->isValid());
        $this->assertSame('Set.MaximumLength', $result->getFirstError()->getMessage());
        $this->assertSame('length', $result->getFirstError()->getParameters()[0]->getKey());
        $this->assertSame(3, $result->getFirstError()->getParameters()[0]->getValue());
    }

    public function testValidateSucceedsWhenPassingAnArrayWithExactNumberOfItemsAsTheMaximum(): Generator
    {
        /** @var Result $result */
        $result = yield (new MaximumLength(3))->validate(['foo', 'bar', 'baz']);

        $this->assertTrue($result->isValid());
        $this->assertNull($result->getFirstError());
    }

    public function testValidateSucceedsWhenPassingAnArrayIteratorWithExactNumberOfItemsAsTheMaximum(): Generator
    {
        /** @var Result $result */
        $result = yield (new MaximumLength(3))->validate(new \ArrayIterator(['foo', 'bar', 'baz']));

        $this->assertTrue($result->isValid());
        $this->assertNull($result->getFirstError());
    }

    public function testValidateSucceedsWhenPassingAnArrayWithLessItemsThanTheMaximum(): Generator
    {
        /** @var Result $result */
        $result = yield (new MaximumLength(3))->validate(['foo', 'bar']);

        $this->assertTrue($result->isValid());
        $this->assertNull($result->getFirstError());
    }

    public function testValidateSucceedsWhenPassingAnArrayIteratorWithLessItemsThanTheMaximum(): Generator
    {
        /** @var Result $result */
        $result = yield (new MaximumLength(3))->validate(new \ArrayIterator(['foo', 'bar']));

        $this->assertTrue($result->isValid());
        $this->assertNull($result->getFirstError());
    }
}
