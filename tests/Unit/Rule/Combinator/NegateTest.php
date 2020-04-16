<?php declare(strict_types=1);

namespace HarmonyIO\ValidationTest\Unit\Rule\Combinator;

use Amp\PHPUnit\AsyncTestCase;
use HarmonyIO\Validation\Result\Result;
use HarmonyIO\Validation\Rule\Combinator\Negate;
use HarmonyIO\Validation\Rule\Rule;
use HarmonyIO\Validation\Rule\Text\MinimumLength;

class NegateTest extends AsyncTestCase
{
    public function testRuleImplementsInterface()
    {
        $this->assertInstanceOf(Rule::class, new Negate(new MinimumLength(10)));
    }

    public function testValidateFailsWhenRuleSucceeds()
    {
        /** @var Result $result */
        $result = yield (new Negate(new MinimumLength(10)))->validate('1234567890');

        $this->assertFalse($result->isValid());
        $this->assertSame('Combinator.Negate', $result->getFirstError()->getMessage());
    }

    public function testValidateSucceedsWhenRuleFails()
    {
        /** @var Result $result */
        $result = yield (new Negate(new MinimumLength(10)))->validate('123456789');

        $this->assertTrue($result->isValid());
        $this->assertNull($result->getFirstError());
    }
}
