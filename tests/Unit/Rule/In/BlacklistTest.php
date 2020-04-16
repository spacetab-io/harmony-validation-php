<?php declare(strict_types=1);

namespace HarmonyIO\ValidationTest\Unit\Rule\In;

use Amp\PHPUnit\AsyncTestCase;
use Generator;
use HarmonyIO\Validation\Result\Result;
use HarmonyIO\Validation\Rule\In\Blacklist;
use HarmonyIO\Validation\Rule\Rule;

class BlacklistTest extends AsyncTestCase
{
    public function testRuleImplementsInterface(): void
    {
        $this->assertInstanceOf(Rule::class, new Blacklist('item1'));
    }

    public function testValidateFailsWhenValueIsTheFirstItemInTheBlacklist(): Generator
    {
        /** @var Result $result */
        $result = yield (new Blacklist('item1', 'item2', 'item3'))->validate('item1');

        $this->assertFalse($result->isValid());
        $this->assertSame('In.Blacklist', $result->getFirstError()->getMessage());
    }

    public function testValidateFailsWhenValueIsTheLastItemInTheBlacklist(): Generator
    {
        /** @var Result $result */
        $result = yield (new Blacklist('item1', 'item2', 'item3'))->validate('item3');

        $this->assertFalse($result->isValid());
        $this->assertSame('In.Blacklist', $result->getFirstError()->getMessage());
    }

    public function testValidateSucceedsWhenValueIsNotInTheBlacklist(): Generator
    {
        /** @var Result $result */
        $result = yield (new Blacklist('item1'))->validate('item3');

        $this->assertTrue($result->isValid());
        $this->assertNull($result->getFirstError());
    }
}
