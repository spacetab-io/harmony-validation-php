<?php declare(strict_types=1);

namespace HarmonyIO\ValidationTest\Unit\Rule\Age;

use Generator;
use HarmonyIO\Validation\Exception\InvalidAgeRange;
use HarmonyIO\Validation\Result\Result;
use HarmonyIO\Validation\Rule\Age\Range;
use HarmonyIO\ValidationTest\Unit\Rule\DateTimeTestCase;

class RangeTest extends DateTimeTestCase
{
    /**
     * RangeTest constructor.
     *
     * @param string|null $name
     * @param array<mixed> $data
     * @param mixed $dataName
     */
    public function __construct(?string $name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName, Range::class, 18, 21);
    }

    public function testConstructorThrowsOnInvalidRange(): void
    {
        $this->expectException(InvalidAgeRange::class);
        $this->expectExceptionMessage('The minimum age (`21`) can not be greater than the maximum age (`18`).');

        new Range(21, 18);
    }

    public function testValidateFailsWhenAgeIsLessThanMinimum(): Generator
    {
        /** @var Result $result */
        $result = yield (new Range(18, 21))->validate(
            // phpcs:ignore PSR2.Methods.FunctionCallSignature.Indent,PSR2.Methods.FunctionCallSignature.CloseBracketLine
            (new \DateTimeImmutable())->sub(new \DateInterval('P18Y'))->add(new \DateInterval('P1D')),
        );

        $this->assertFalse($result->isValid());
        $this->assertSame('Age.Minimum', $result->getErrors()[0]->getMessage());
        $this->assertSame('age', $result->getErrors()[0]->getParameters()[0]->getKey());
        $this->assertSame(18, $result->getErrors()[0]->getParameters()[0]->getValue());
    }

    public function testValidateFailsWhenAgeIsMoreThanMaximum(): Generator
    {
        /** @var Result $result */
        $result = yield (new Range(18, 21))->validate(
            // phpcs:ignore PSR2.Methods.FunctionCallSignature.Indent,PSR2.Methods.FunctionCallSignature.CloseBracketLine
            (new \DateTimeImmutable())->sub(new \DateInterval('P21Y1D')),
        );

        $this->assertFalse($result->isValid());
        $this->assertSame('Age.Maximum', $result->getErrors()[0]->getMessage());
        $this->assertSame('age', $result->getErrors()[0]->getParameters()[0]->getKey());
        $this->assertSame(21, $result->getErrors()[0]->getParameters()[0]->getValue());
    }

    public function testValidateSucceedsWhenAgeIsExactlyMinimum(): Generator
    {
        /** @var Result $result */
        $result = yield (new Range(18, 21))->validate(
            // phpcs:ignore PSR2.Methods.FunctionCallSignature.Indent,PSR2.Methods.FunctionCallSignature.CloseBracketLine
            (new \DateTimeImmutable())->sub(new \DateInterval('P18Y')),
        );

        $this->assertTrue($result->isValid());
        $this->assertCount(0, $result->getErrors());
    }

    public function testValidateSucceedsWhenAgeIsExactlyMaximum(): Generator
    {
        /** @var Result $result */
        $result = yield (new Range(18, 21))->validate(
            // phpcs:ignore PSR2.Methods.FunctionCallSignature.Indent,PSR2.Methods.FunctionCallSignature.CloseBracketLine
            (new \DateTimeImmutable())->sub(new \DateInterval('P21Y')),
        );

        $this->assertTrue($result->isValid());
        $this->assertCount(0, $result->getErrors());
    }

    public function testValidateSucceedsWhenAgeIsInRange(): Generator
    {
        /** @var Result $result */
        $result = yield (new Range(18, 21))->validate(
            // phpcs:ignore PSR2.Methods.FunctionCallSignature.Indent,PSR2.Methods.FunctionCallSignature.CloseBracketLine
            (new \DateTimeImmutable())->sub(new \DateInterval('P19Y6M')),
        );

        $this->assertTrue($result->isValid());
        $this->assertCount(0, $result->getErrors());
    }
}
