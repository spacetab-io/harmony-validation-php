<?php declare(strict_types=1);

namespace HarmonyIO\ValidationTest\Unit\Rule\Numeric;

use Generator;
use HarmonyIO\Validation\Result\Result;
use HarmonyIO\Validation\Rule\Numeric\Negative;
use HarmonyIO\ValidationTest\Unit\Rule\NumericTestCase;

class NegativeTest extends NumericTestCase
{
    /**
     * NegativeTest constructor.
     *
     * @param string|null $name
     * @param array<mixed> $data
     * @param string $dataName
     */
    public function __construct(?string $name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName, Negative::class);
    }

    public function testValidateFailsWhenPassingInZeroAsAnInteger(): Generator
    {
        /** @var Result $result */
        $result = yield (new Negative())->validate(0);

        $this->assertFalse($result->isValid());
        $this->assertSame('Numeric.Negative', $result->getFirstError()->getMessage());
    }

    public function testValidateFailsWhenPassingInZeroAsAFloat(): Generator
    {
        /** @var Result $result */
        $result = yield (new Negative())->validate(0.0);

        $this->assertFalse($result->isValid());
        $this->assertSame('Numeric.Negative', $result->getFirstError()->getMessage());
    }

    public function testValidateFailsWhenPassingInZeroAsAnIntegerAsAString(): Generator
    {
        /** @var Result $result */
        $result = yield (new Negative())->validate('0');

        $this->assertFalse($result->isValid());
        $this->assertSame('Numeric.Negative', $result->getFirstError()->getMessage());
    }

    public function testValidateFailsWhenPassingInZeroAsAFloatAsAString(): Generator
    {
        /** @var Result $result */
        $result = yield (new Negative())->validate('0.0');

        $this->assertFalse($result->isValid());
        $this->assertSame('Numeric.Negative', $result->getFirstError()->getMessage());
    }

    public function testValidateFailsWhenPassingInAPositiveInteger(): Generator
    {
        /** @var Result $result */
        $result = yield (new Negative())->validate(1);

        $this->assertFalse($result->isValid());
        $this->assertSame('Numeric.Negative', $result->getFirstError()->getMessage());
    }

    public function testValidateFailsWhenPassingInAPositiveAFloat(): Generator
    {
        /** @var Result $result */
        $result = yield (new Negative())->validate(0.1);

        $this->assertFalse($result->isValid());
        $this->assertSame('Numeric.Negative', $result->getFirstError()->getMessage());
    }

    public function testValidateFailsWhenPassingInAPositiveIntegerAsAString(): Generator
    {
        /** @var Result $result */
        $result = yield (new Negative())->validate('1');

        $this->assertFalse($result->isValid());
        $this->assertSame('Numeric.Negative', $result->getFirstError()->getMessage());
    }

    public function testValidateFailsWhenPassingInAPositiveFloatAsAString(): Generator
    {
        /** @var Result $result */
        $result = yield (new Negative())->validate('0.1');

        $this->assertFalse($result->isValid());
        $this->assertSame('Numeric.Negative', $result->getFirstError()->getMessage());
    }

    public function testValidateSucceedsWhenPassingANegativeInteger(): Generator
    {
        /** @var Result $result */
        $result = yield (new Negative())->validate(-1);

        $this->assertTrue($result->isValid());
        $this->assertNull($result->getFirstError());
    }

    public function testValidateSucceedsWhenPassingANegativeFloat(): Generator
    {
        /** @var Result $result */
        $result = yield (new Negative())->validate('-0.1');

        $this->assertTrue($result->isValid());
        $this->assertNull($result->getFirstError());
    }

    public function testValidateSucceedsWhenPassingANegativeIntegerAsString(): Generator
    {
        /** @var Result $result */
        $result = yield (new Negative())->validate('-1');

        $this->assertTrue($result->isValid());
        $this->assertNull($result->getFirstError());
    }

    public function testValidateSucceedsWhenPassingANegativeFloatAsString(): Generator
    {
        /** @var Result $result */
        $result = yield (new Negative())->validate('-0.1');

        $this->assertTrue($result->isValid());
        $this->assertNull($result->getFirstError());
    }
}
