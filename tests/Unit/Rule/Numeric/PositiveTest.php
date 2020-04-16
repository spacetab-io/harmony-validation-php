<?php declare(strict_types=1);

namespace HarmonyIO\ValidationTest\Unit\Rule\Numeric;

use Generator;
use HarmonyIO\Validation\Result\Result;
use HarmonyIO\Validation\Rule\Numeric\Positive;
use HarmonyIO\ValidationTest\Unit\Rule\NumericTestCase;

class PositiveTest extends NumericTestCase
{
    /**
     * PositiveTest constructor.
     *
     * @param string|null $name
     * @param array<mixed> $data
     * @param string $dataName
     */
    public function __construct(?string $name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName, Positive::class);
    }

    public function testValidateFailsWhenPassingInANegativeInteger(): Generator
    {
        /** @var Result $result */
        $result = yield (new Positive())->validate(-1);

        $this->assertFalse($result->isValid());
        $this->assertSame('Numeric.Positive', $result->getFirstError()->getMessage());
    }

    public function testValidateFailsWhenPassingInANegativeIntegerAsAString(): Generator
    {
        /** @var Result $result */
        $result = yield (new Positive())->validate('-1');

        $this->assertFalse($result->isValid());
        $this->assertSame('Numeric.Positive', $result->getFirstError()->getMessage());
    }

    public function testValidateFailsWhenPassingInANegativeFloat(): Generator
    {
        /** @var Result $result */
        $result = yield (new Positive())->validate(-0.1);

        $this->assertFalse($result->isValid());
        $this->assertSame('Numeric.Positive', $result->getFirstError()->getMessage());
    }

    public function testValidateFailsWhenPassingInANegativeFloatAsAString(): Generator
    {
        /** @var Result $result */
        $result = yield (new Positive())->validate('-0.1');

        $this->assertFalse($result->isValid());
        $this->assertSame('Numeric.Positive', $result->getFirstError()->getMessage());
    }

    public function testValidateSucceedsWhenPassingInZeroAsAnInteger(): Generator
    {
        /** @var Result $result */
        $result = yield (new Positive())->validate(0);

        $this->assertTrue($result->isValid());
        $this->assertNull($result->getFirstError());
    }

    public function testValidateSucceedsWhenPassingInZeroAsAFloat(): Generator
    {
        /** @var Result $result */
        $result = yield (new Positive())->validate(0.0);

        $this->assertTrue($result->isValid());
        $this->assertNull($result->getFirstError());
    }

    public function testValidateSucceedsWhenPassingInZeroAsAString(): Generator
    {
        /** @var Result $result */
        $result = yield (new Positive())->validate('0.0');

        $this->assertTrue($result->isValid());
        $this->assertNull($result->getFirstError());
    }

    public function testValidateSucceedsWhenPassingInAPositiveInteger(): Generator
    {
        /** @var Result $result */
        $result = yield (new Positive())->validate(1);

        $this->assertTrue($result->isValid());
        $this->assertNull($result->getFirstError());
    }

    public function testValidateSucceedsWhenPassingInAPositiveIntegerAsAString(): Generator
    {
        /** @var Result $result */
        $result = yield (new Positive())->validate('1');

        $this->assertTrue($result->isValid());
        $this->assertNull($result->getFirstError());
    }

    public function testValidateSucceedsWhenPassingInAPositiveFloat(): Generator
    {
        /** @var Result $result */
        $result = yield (new Positive())->validate(0.1);

        $this->assertTrue($result->isValid());
        $this->assertNull($result->getFirstError());
    }

    public function testValidateSucceedsWhenPassingInAPositiveFloatAsAString(): Generator
    {
        /** @var Result $result */
        $result = yield (new Positive())->validate('0.1');

        $this->assertTrue($result->isValid());
        $this->assertNull($result->getFirstError());
    }
}
