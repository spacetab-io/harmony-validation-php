<?php declare(strict_types=1);

namespace HarmonyIO\ValidationTest\Unit\Rule\Numeric;

use Generator;
use HarmonyIO\Validation\Result\Result;
use HarmonyIO\Validation\Rule\Numeric\Maximum;
use HarmonyIO\ValidationTest\Unit\Rule\NumericTestCase;

class MaximumTest extends NumericTestCase
{
    /**
     * MaximumTest constructor.
     *
     * @param string|null $name
     * @param array<mixed> $data
     * @param string $dataName
     */
    public function __construct(?string $name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName, Maximum::class, 10);
    }

    public function testValidateFailsWhenPassingAnIntegerWhichIsLargerThanMaximum(): Generator
    {
        /** @var Result $result */
        $result = yield (new Maximum(10))->validate(11);

        $this->assertFalse($result->isValid());
        $this->assertSame('Numeric.Maximum', $result->getFirstError()->getMessage());
        $this->assertSame('maximum', $result->getFirstError()->getParameters()[0]->getKey());
        $this->assertSame(10.0, $result->getFirstError()->getParameters()[0]->getValue());
    }

    public function testValidateFailsWhenPassingAFloatWhichIsLargerThanMaximum(): Generator
    {
        /** @var Result $result */
        $result = yield (new Maximum(10))->validate(11.1);

        $this->assertFalse($result->isValid());
        $this->assertSame('Numeric.Maximum', $result->getFirstError()->getMessage());
        $this->assertSame('maximum', $result->getFirstError()->getParameters()[0]->getKey());
        $this->assertSame(10.0, $result->getFirstError()->getParameters()[0]->getValue());
    }

    public function testValidateFailsWhenPassingAnIntegerAsAStringWhichIsLargerThanMaximum(): Generator
    {
        /** @var Result $result */
        $result = yield (new Maximum(10))->validate('11');

        $this->assertFalse($result->isValid());
        $this->assertSame('Numeric.Maximum', $result->getFirstError()->getMessage());
        $this->assertSame('maximum', $result->getFirstError()->getParameters()[0]->getKey());
        $this->assertSame(10.0, $result->getFirstError()->getParameters()[0]->getValue());
    }

    public function testValidateFailsWhenPassingAFloatAsAStringWhichIsLargerThanMaximum(): Generator
    {
        /** @var Result $result */
        $result = yield (new Maximum(10))->validate('11.1');

        $this->assertFalse($result->isValid());
        $this->assertSame('Numeric.Maximum', $result->getFirstError()->getMessage());
        $this->assertSame('maximum', $result->getFirstError()->getParameters()[0]->getKey());
        $this->assertSame(10.0, $result->getFirstError()->getParameters()[0]->getValue());
    }

    public function testValidateSucceedWhenPassingAnIntegerWhichIsLessThanMaximum(): Generator
    {
        /** @var Result $result */
        $result = yield (new Maximum(10))->validate(1);

        $this->assertTrue($result->isValid());
        $this->assertNull($result->getFirstError());
    }

    public function testValidateSucceedWhenPassingAnIntegerWhichIsExactlyMaximum(): Generator
    {
        /** @var Result $result */
        $result = yield (new Maximum(10))->validate(10);

        $this->assertTrue($result->isValid());
        $this->assertNull($result->getFirstError());
    }

    public function testValidateSucceedWhenPassingAFloatWhichIsLessThanMaximum(): Generator
    {
        /** @var Result $result */
        $result = yield (new Maximum(10))->validate(1.1);

        $this->assertTrue($result->isValid());
        $this->assertNull($result->getFirstError());
    }

    public function testValidateSucceedWhenPassingAFloatWhichIsExactlyMaximum(): Generator
    {
        /** @var Result $result */
        $result = yield (new Maximum(10))->validate(10.0);

        $this->assertTrue($result->isValid());
        $this->assertNull($result->getFirstError());
    }

    public function testValidateSucceedsWhenPassingAnIntegerAsAStringWhichIsSmallerThanMaximum(): Generator
    {
        /** @var Result $result */
        $result = yield (new Maximum(10))->validate('1');

        $this->assertTrue($result->isValid());
        $this->assertNull($result->getFirstError());
    }

    public function testValidateSucceedsWhenPassingAnIntegerAsAStringWhichIsExactlyThanMaximum(): Generator
    {
        /** @var Result $result */
        $result = yield (new Maximum(10))->validate('10');

        $this->assertTrue($result->isValid());
        $this->assertNull($result->getFirstError());
    }

    public function testValidateSucceedsWhenPassingAFloatAsAStringWhichIsSmallerThanMaximum(): Generator
    {
        /** @var Result $result */
        $result = yield (new Maximum(10))->validate('1.1');

        $this->assertTrue($result->isValid());
        $this->assertNull($result->getFirstError());
    }

    public function testValidateSucceedsWhenPassingAFloatAsAStringWhichIsExactlyThanMaximum(): Generator
    {
        /** @var Result $result */
        $result = yield (new Maximum(10))->validate('10.0');

        $this->assertTrue($result->isValid());
        $this->assertNull($result->getFirstError());
    }
}
