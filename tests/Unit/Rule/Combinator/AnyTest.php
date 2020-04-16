<?php declare(strict_types=1);

namespace HarmonyIO\ValidationTest\Unit\Rule\Combinator;

use Amp\PHPUnit\AsyncTestCase;
use HarmonyIO\Validation\Result\Result;
use HarmonyIO\Validation\Rule\Combinator\All;
use HarmonyIO\Validation\Rule\Combinator\Any;
use HarmonyIO\Validation\Rule\Rule;
use HarmonyIO\Validation\Rule\Text\MaximumLength;
use HarmonyIO\Validation\Rule\Text\MinimumLength;

class AnyTest extends AsyncTestCase
{
    public function testRuleImplementsInterface()
    {
        $this->assertInstanceOf(Rule::class, new Any());
    }

    public function testValidateFailsWhenAllRulesAreInvalid()
    {
        /** @var Result $result */
        $result = yield (new Any(
            new MinimumLength(11),
            new MaximumLength(9)
        ))->validate('Test value');

        $this->assertFalse($result->isValid());
        $this->assertCount(2, $result->getErrors());
        $this->assertSame('Text.MinimumLength', $result->getFirstError()->getMessage());
        $this->assertSame('Text.MaximumLength', $result->getErrors()[1]->getMessage());
    }

    public function testValidateSucceedsWhenNoRulesAreAdded()
    {
        /** @var Result $result */
        $result = yield (new Any())->validate('Test value');

        $this->assertTrue($result->isValid());
        $this->assertNull($result->getFirstError());
    }

    public function testValidateSucceedsWhenBothRulesAreValid()
    {
        /** @var Result $result */
        $result = yield (new Any(
            new MinimumLength(3),
            new MaximumLength(15)
        ))->validate('Test value');

        $this->assertTrue($result->isValid());
        $this->assertNull($result->getFirstError());
    }

    public function testValidateSucceedsWhenFirstRuleIsValid()
    {
        /** @var Result $result */
        $result = yield (new Any(
            new MinimumLength(11),
            new MaximumLength(15)
        ))->validate('Test value');

        $this->assertTrue($result->isValid());
        $this->assertNull($result->getFirstError());
    }

    public function testValidateSucceedsWhenLastRuleIsValid()
    {
        /** @var Result $result */
        $result = yield (new Any(
            new MinimumLength(3),
            new MaximumLength(9)
        ))->validate('Test value');

        $this->assertTrue($result->isValid());
        $this->assertNull($result->getFirstError());
    }

    public function testValidateSucceedsWhenRulesContainAllRuleWithMoreErrorsThanAnyRules()
    {
        /** @var Result $result */
        $result = yield (new Any(new All(
            new MaximumLength(3),
            new MaximumLength(3),
            new MaximumLength(3)
        ), new MinimumLength(3)))->validate('Test value');

        $this->assertTrue($result->isValid());
        $this->assertNull($result->getFirstError());
    }
}
