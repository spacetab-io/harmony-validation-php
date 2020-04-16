<?php declare(strict_types=1);

namespace HarmonyIO\ValidationTest\Unit\Rule\Numeric;

use Generator;
use HarmonyIO\Validation\Result\Result;
use HarmonyIO\Validation\Rule\Numeric\NumericType;
use HarmonyIO\ValidationTest\Unit\Rule\NumericTestCase;

class NumericTypeTest extends NumericTestCase
{
    /**
     * NumericTypeTest constructor.
     *
     * @param string|null $name
     * @param array<mixed> $data
     * @param string $dataName
     */
    public function __construct(?string $name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName, NumericType::class);
    }

    public function testValidateSucceedsWhenPassingAnInteger(): Generator
    {
        /** @var Result $result */
        $result = yield (new NumericType())->validate(1);

        $this->assertTrue($result->isValid());
        $this->assertNull($result->getFirstError());
    }

    public function testValidateSucceedsWhenPassingAFloat(): Generator
    {
        /** @var Result $result */
        $result = yield (new NumericType())->validate(1.1);

        $this->assertTrue($result->isValid());
        $this->assertNull($result->getFirstError());
    }

    public function testValidateSucceedsWhenPassingAnIntegerAsAString(): Generator
    {
        /** @var Result $result */
        $result = yield (new NumericType())->validate('1');

        $this->assertTrue($result->isValid());
        $this->assertNull($result->getFirstError());
    }

    public function testValidateSucceedsWhenPassingAFloatAsAString(): Generator
    {
        /** @var Result $result */
        $result = yield (new NumericType())->validate('1.1');

        $this->assertTrue($result->isValid());
        $this->assertNull($result->getFirstError());
    }
}
