<?php declare(strict_types=1);

namespace HarmonyIO\ValidationTest\Unit\Rule\Set;

use Generator;
use HarmonyIO\Validation\Result\Result;
use HarmonyIO\Validation\Rule\Set\Countable;
use HarmonyIO\ValidationTest\Unit\Rule\CountableTestCase;

class CountableTest extends CountableTestCase
{
    /**
     * CountableTest constructor.
     *
     * @param string|null $name
     * @param array<mixed> $data
     * @param string $dataName
     */
    public function __construct(?string $name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName, Countable::class);
    }

    public function testValidateSucceedsWhenPassingAnEmptyArray(): Generator
    {
        /** @var Result $result */
        $result = yield (new Countable())->validate([]);

        $this->assertTrue($result->isValid());
        $this->assertNull($result->getFirstError());
    }

    public function testValidateSucceedsWhenPassingAFilledArray(): Generator
    {
        /** @var Result $result */
        $result = yield (new Countable())->validate(['foo', 'bar']);

        $this->assertTrue($result->isValid());
        $this->assertNull($result->getFirstError());
    }

    public function testValidateSucceedsWHenPassingACountableObject(): Generator
    {
        /** @var Result $result */
        $result = yield (new Countable())->validate(new \ArrayIterator(['foo', 'bar']));

        $this->assertTrue($result->isValid());
        $this->assertNull($result->getFirstError());
    }
}
