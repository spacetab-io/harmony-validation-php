<?php declare(strict_types=1);

namespace HarmonyIO\ValidationTest\Unit\Rule\Numeric;

use Generator;
use HarmonyIO\Validation\Result\Result;
use HarmonyIO\Validation\Rule\Numeric\Minimum;
use HarmonyIO\ValidationTest\Unit\Rule\NumericTestCase;

class MinimumTest extends NumericTestCase
{
    /**
     * MinimumTest constructor.
     *
     * @param string|null $name
     * @param array<string> $data
     * @param mixed $dataName
     */
    public function __construct(?string $name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName, Minimum::class, 10);
    }

    public function testValidateFailsWhenPassingAnIntegerWhichIsSmallerThanMinimum(): Generator
    {
        /** @var Result $result */
        $result = yield (new Minimum(10))->validate(9);

        $this->assertFalse($result->isValid());
        $this->assertSame('Numeric.Minimum', $result->getFirstError()->getMessage());
        $this->assertSame('minimum', $result->getFirstError()->getParameters()[0]->getKey());
        $this->assertSame(10.0, $result->getFirstError()->getParameters()[0]->getValue());
    }

    public function testValidateFailsWhenPassingAnIntegerAsAStringWhichIsSmallerThanMinimum(): Generator
    {
        /** @var Result $result */
        $result = yield (new Minimum(10))->validate('9');

        $this->assertFalse($result->isValid());
        $this->assertSame('Numeric.Minimum', $result->getFirstError()->getMessage());
        $this->assertSame('minimum', $result->getFirstError()->getParameters()[0]->getKey());
        $this->assertSame(10.0, $result->getFirstError()->getParameters()[0]->getValue());
    }

    public function testValidateFailsWhenPassingAFloatWhichIsSmallerThanMinimum(): Generator
    {
        /** @var Result $result */
        $result = yield (new Minimum(10))->validate(9.9);

        $this->assertFalse($result->isValid());
        $this->assertSame('Numeric.Minimum', $result->getFirstError()->getMessage());
        $this->assertSame('minimum', $result->getFirstError()->getParameters()[0]->getKey());
        $this->assertSame(10.0, $result->getFirstError()->getParameters()[0]->getValue());
    }

    public function testValidateFailsWhenPassingAFloatAsAStringWhichIsSmallerThanMinimum(): Generator
    {
        /** @var Result $result */
        $result = yield (new Minimum(10))->validate('9.9');

        $this->assertFalse($result->isValid());
        $this->assertSame('Numeric.Minimum', $result->getFirstError()->getMessage());
        $this->assertSame('minimum', $result->getFirstError()->getParameters()[0]->getKey());
        $this->assertSame(10.0, $result->getFirstError()->getParameters()[0]->getValue());
    }

    public function testValidateSucceedsWhenPassingAnIntegerWhichIsExactlyMinimum(): Generator
    {
        /** @var Result $result */
        $result = yield (new Minimum(10))->validate(10);

        $this->assertTrue($result->isValid());
        $this->assertNull($result->getFirstError());
    }

    public function testValidateSucceedsWhenPassingAnIntegerWhichIsLargerThanMinimum(): Generator
    {
        /** @var Result $result */
        $result = yield (new Minimum(10))->validate(11);

        $this->assertTrue($result->isValid());
        $this->assertNull($result->getFirstError());
    }

    public function testValidateSucceedsWhenPassingAnIntegerAsAStringWhichIsExactlyMinimum(): Generator
    {
        /** @var Result $result */
        $result = yield (new Minimum(10))->validate('10');

        $this->assertTrue($result->isValid());
        $this->assertNull($result->getFirstError());
    }

    public function testValidateSucceedsWhenPassingAnIntegerAsAStringWhichIsLargerThanMinimum(): Generator
    {
        /** @var Result $result */
        $result = yield (new Minimum(10))->validate('11');

        $this->assertTrue($result->isValid());
        $this->assertNull($result->getFirstError());
    }

    public function testValidateSucceedsWhenPassingAFloatWhichIsExactlyMinimum(): Generator
    {
        /** @var Result $result */
        $result = yield (new Minimum(10))->validate(10.0);

        $this->assertTrue($result->isValid());
        $this->assertNull($result->getFirstError());
    }

    public function testValidateSucceedsWhenPassingAFloatWhichIsLargerThanMinimum(): Generator
    {
        /** @var Result $result */
        $result = yield (new Minimum(10))->validate(10.1);

        $this->assertTrue($result->isValid());
        $this->assertNull($result->getFirstError());
    }

    public function testValidateSucceedsWhenPassingAFloatAsAStringWhichIsExactlyMinimum(): Generator
    {
        /** @var Result $result */
        $result = yield (new Minimum(10))->validate('10.0');

        $this->assertTrue($result->isValid());
        $this->assertNull($result->getFirstError());
    }

    public function testValidateSucceedsWhenPassingAFloatAsAStringWhichIsLargerThanMinimum(): Generator
    {
        /** @var Result $result */
        $result = yield (new Minimum(10))->validate('10.1');

        $this->assertTrue($result->isValid());
        $this->assertNull($result->getFirstError());
    }
}
