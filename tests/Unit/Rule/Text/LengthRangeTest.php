<?php declare(strict_types=1);

namespace HarmonyIO\ValidationTest\Unit\Rule\Text;

use Generator;
use HarmonyIO\Validation\Exception\InvalidNumericalRange;
use HarmonyIO\Validation\Result\Result;
use HarmonyIO\Validation\Rule\Text\LengthRange;
use HarmonyIO\ValidationTest\Unit\Rule\StringTestCase;

class LengthRangeTest extends StringTestCase
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
        parent::__construct($name, $data, $dataName, LengthRange::class, 10, 12);
    }

    public function testConstructorThrowsUpWhenMinimumLengthIsGreaterThanTheMaximumLength(): void
    {
        $this->expectException(InvalidNumericalRange::class);
        $this->expectExceptionMessage('The minimum (`12`) can not be greater than the maximum (`10`).');

        new LengthRange(12, 10);
    }

    public function testValidateFailsWhenPassingAStringSmallerThanTheMinimumLength(): Generator
    {
        /** @var Result $result */
        $result = yield (new LengthRange(10, 12))->validate('€€€€€€€€€');

        $this->assertFalse($result->isValid());
        $this->assertSame('Text.MinimumLength', $result->getFirstError()->getMessage());
        $this->assertSame('length', $result->getFirstError()->getParameters()[0]->getKey());
        $this->assertSame(10, $result->getFirstError()->getParameters()[0]->getValue());
    }

    public function testValidateFailsWhenPassingAStringLargerThanTheMaximumLength(): Generator
    {
        /** @var Result $result */
        $result = yield (new LengthRange(10, 12))->validate('€€€€€€€€€€€€€');

        $this->assertFalse($result->isValid());
        $this->assertSame('Text.MaximumLength', $result->getFirstError()->getMessage());
        $this->assertSame('length', $result->getFirstError()->getParameters()[0]->getKey());
        $this->assertSame(12, $result->getFirstError()->getParameters()[0]->getValue());
    }

    public function testValidateSucceedsWhenPassingAStringLargerThanTheMinimumLengthAndSmallerThanMaximumLength(): Generator
    {
        /** @var Result $result */
        $result = yield (new LengthRange(10, 12))->validate('€€€€€€€€€€€');

        $this->assertTrue($result->isValid());
        $this->assertNull($result->getFirstError());
    }

    public function testValidateSucceedsWhenPassingAStringWithExactlyTheMinimumLength(): Generator
    {
        /** @var Result $result */
        $result = yield (new LengthRange(10, 12))->validate('€€€€€€€€€€');

        $this->assertTrue($result->isValid());
        $this->assertNull($result->getFirstError());
    }

    public function testValidateSucceedsWhenPassingAStringExactlyTheMaximumLength(): Generator
    {
        /** @var Result $result */
        $result = yield (new LengthRange(10, 12))->validate('€€€€€€€€€€€€');

        $this->assertTrue($result->isValid());
        $this->assertNull($result->getFirstError());
    }
}
