<?php declare(strict_types=1);

namespace HarmonyIO\ValidationTest\Unit\Rule\Combinator;

use Amp\PHPUnit\AsyncTestCase;
use HarmonyIO\Validation\Result\Result;
use HarmonyIO\Validation\Rule\Combinator\All;
use HarmonyIO\Validation\Rule\Combinator\AtLeast;
use HarmonyIO\Validation\Rule\Rule;
use HarmonyIO\Validation\Rule\Text\MaximumLength;
use HarmonyIO\Validation\Rule\Text\MinimumLength;

class AtLeastTest extends AsyncTestCase
{
    public function testRuleImplementsInterface()
    {
        $this->assertInstanceOf(Rule::class, new AtLeast(0));
    }

    public function testValidateSucceedsWhenNoRulesAreAdded()
    {
        /** @var Result $result */
        $result = yield (new AtLeast(0))->validate('Test value');

        $this->assertTrue($result->isValid());
        $this->assertNull($result->getFirstError());
    }

    public function testValidateFailsWhenUnderTheMinimumOfValidRules()
    {
        /** @var Result $result */
        $result = yield (new AtLeast(
            3,
            new MinimumLength(11),
            new MaximumLength(15)
        ))->validate('Test value');

        $this->assertFalse($result->isValid());
        $this->assertSame('Text.MinimumLength', $result->getFirstError()->getMessage());
        $this->assertCount(1, $result->getErrors());
    }

    public function testValidateSucceedsWhenOverTheMinimumOfValidRules()
    {
        /** @var Result $result */
        $result = yield (new AtLeast(
            1,
            new MinimumLength(3),
            new MaximumLength(15)
        ))->validate('Test value');

        $this->assertTrue($result->isValid());
        $this->assertNull($result->getFirstError());
    }

    public function testValidateSucceedsWhenExactlyTheMinimumOfValidRules()
    {
        /** @var Result $result */
        $result = yield (new AtLeast(
            2,
            new MinimumLength(3),
            new MaximumLength(15)
        ))->validate('Test value');

        $this->assertTrue($result->isValid());
        $this->assertNull($result->getFirstError());
    }

    public function testValidateSucceedsWhenRulesContainAllRuleWithMoreErrorsThanAtLeastRules()
    {
        /** @var Result $result */
        $result = yield (new AtLeast(2, new All(
            new MaximumLength(3),
            new MaximumLength(3),
            new MaximumLength(3)
        ), new MinimumLength(3), new MinimumLength(3)))->validate('Test value');

        $this->assertTrue($result->isValid());
        $this->assertNull($result->getFirstError());
    }
}
