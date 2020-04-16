<?php declare(strict_types=1);

namespace HarmonyIO\ValidationTest\Unit\Rule\Set;

use Generator;
use HarmonyIO\Validation\Result\Result;
use HarmonyIO\Validation\Rule\Set\MinimumLength;
use HarmonyIO\ValidationTest\Unit\Rule\CountableTestCase;

class MinimumLengthTest extends CountableTestCase
{
    /**
     * MinimumLengthTest constructor.
     *
     * @param string|null $name
     * @param array<mixed> $data
     * @param string $dataName
     */
    public function __construct(?string $name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName, MinimumLength::class, 3);
    }

    public function testValidateFailsWhenPassingAnArrayWithLessItemsThanTheMinimum(): Generator
    {
        /** @var Result $result */
        $result = yield (new MinimumLength(3))->validate([]);

        $this->assertFalse($result->isValid());
        $this->assertSame('Set.MinimumLength', $result->getFirstError()->getMessage());
        $this->assertSame('length', $result->getFirstError()->getParameters()[0]->getKey());
        $this->assertSame(3, $result->getFirstError()->getParameters()[0]->getValue());
    }

    public function testValidateFailsWhenPassingAnArrayIteratorWithLessItemsThanTheMinimum(): Generator
    {
        /** @var Result $result */
        $result = yield (new MinimumLength(3))->validate(new \ArrayIterator(['foo', 'bar']));

        $this->assertFalse($result->isValid());
        $this->assertSame('Set.MinimumLength', $result->getFirstError()->getMessage());
        $this->assertSame('length', $result->getFirstError()->getParameters()[0]->getKey());
        $this->assertSame(3, $result->getFirstError()->getParameters()[0]->getValue());
    }

    public function testValidateSucceedsWhenPassingAnArrayWithExactNumberOfItemsAsTheMinimum(): Generator
    {
        /** @var Result $result */
        $result = yield (new MinimumLength(3))->validate(['foo', 'bar', 'baz']);

        $this->assertTrue($result->isValid());
        $this->assertNull($result->getFirstError());
    }

    public function testValidateSucceedsWhenPassingAnArrayIteratorWithExactNumberOfItemsAsTheMinimum(): Generator
    {
        /** @var Result $result */
        $result = yield (new MinimumLength(3))->validate(new \ArrayIterator(['foo', 'bar', 'baz']));

        $this->assertTrue($result->isValid());
        $this->assertNull($result->getFirstError());
    }

    public function testValidateSucceedsWhenPassingAnArrayWithMoreItemsThanTheMinimum(): Generator
    {
        /** @var Result $result */
        $result = yield (new MinimumLength(3))->validate(['foo', 'bar', 'baz', 'qux']);

        $this->assertTrue($result->isValid());
        $this->assertNull($result->getFirstError());
    }

    public function testValidateSucceedsWhenPassingAnArrayIteratorWithMoreItemsThanTheMinimum(): Generator
    {
        /** @var Result $result */
        $result = yield (new MinimumLength(3))->validate(new \ArrayIterator(['foo', 'bar', 'baz', 'qux']));

        $this->assertTrue($result->isValid());
        $this->assertNull($result->getFirstError());
    }
}
