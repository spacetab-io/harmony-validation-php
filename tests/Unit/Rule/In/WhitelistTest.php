<?php declare(strict_types=1);

namespace HarmonyIO\ValidationTest\Unit\Rule\In;

use Amp\PHPUnit\AsyncTestCase;
use Generator;
use HarmonyIO\Validation\Result\Result;
use HarmonyIO\Validation\Rule\In\Whitelist;
use HarmonyIO\Validation\Rule\Rule;

class WhitelistTest extends AsyncTestCase
{
    public function testRuleImplementsInterface(): void
    {
        $this->assertInstanceOf(Rule::class, new Whitelist('item1'));
    }

    public function testValidateFailsWhenValueIsNotInTheWhitelist(): Generator
    {
        /** @var Result $result */
        $result = yield (new Whitelist('item1'))->validate('item3');

        $this->assertFalse($result->isValid());
        $this->assertSame('In.Whitelist', $result->getFirstError()->getMessage());
    }

    public function testValidateSucceedsWhenValueIsTheFirstItemInTheWhitelist(): Generator
    {
        /** @var Result $result */
        $result = yield (new Whitelist('item1', 'item2', 'item3'))->validate('item1');

        $this->assertTrue($result->isValid());
        $this->assertNull($result->getFirstError());
    }

    public function testValidateSucceedsWhenValueIsTheLastItemInTheWhitelist(): Generator
    {
        /** @var Result $result */
        $result = yield (new Whitelist('item1', 'item2', 'item3'))->validate('item3');

        $this->assertTrue($result->isValid());
        $this->assertNull($result->getFirstError());
    }
}
