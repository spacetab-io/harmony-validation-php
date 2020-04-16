<?php declare(strict_types=1);

namespace HarmonyIO\ValidationTest\Unit\Rule\Age;

use Generator;
use HarmonyIO\Validation\Result\Result;
use HarmonyIO\Validation\Rule\Age\Minimum;
use HarmonyIO\ValidationTest\Unit\Rule\DateTimeTestCase;

class MinimumTest extends DateTimeTestCase
{
    /**
     * MinimumTest constructor.
     *
     * @param string|null $name
     * @param array<mixed> $data
     * @param mixed $dataName
     */
    public function __construct(?string $name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName, Minimum::class, 18);
    }

    public function testValidateFailsWhenAgeIsLessThanMinimum(): Generator
    {
        /** @var Result $result */
        $result = yield (new Minimum(18))->validate(
            // phpcs:ignore PSR2.Methods.FunctionCallSignature.Indent,PSR2.Methods.FunctionCallSignature.CloseBracketLine
            (new \DateTimeImmutable())->sub(new \DateInterval('P18Y'))->add(new \DateInterval('P1D')),
        );

        $this->assertFalse($result->isValid());
        $this->assertSame('Age.Minimum', $result->getErrors()[0]->getMessage());
        $this->assertSame('age', $result->getErrors()[0]->getParameters()[0]->getKey());
        $this->assertSame(18, $result->getErrors()[0]->getParameters()[0]->getValue());
    }

    public function testValidateSucceedsWhenAgeIsExactlyMinimum(): Generator
    {
        /** @var Result $result */
        $result = yield (new Minimum(18))->validate(
            // phpcs:ignore PSR2.Methods.FunctionCallSignature.Indent,PSR2.Methods.FunctionCallSignature.CloseBracketLine
            (new \DateTimeImmutable())->sub(new \DateInterval('P18Y')),
        );

        $this->assertTrue($result->isValid());
        $this->assertCount(0, $result->getErrors());
    }

    public function testValidateSucceedsWhenAgeIsMoreThanMinimum(): Generator
    {
        /** @var Result $result */
        $result = yield (new Minimum(18))->validate(
            // phpcs:ignore PSR2.Methods.FunctionCallSignature.Indent,PSR2.Methods.FunctionCallSignature.CloseBracketLine
            (new \DateTimeImmutable())->sub(new \DateInterval('P18Y1D')),
        );

        $this->assertTrue($result->isValid());
        $this->assertCount(0, $result->getErrors());
    }
}
