<?php declare(strict_types=1);

namespace HarmonyIO\ValidationTest\Unit\Rule\Type;

use Amp\PHPUnit\AsyncTestCase;
use Generator;
use HarmonyIO\Validation\Result\Result;
use HarmonyIO\Validation\Rule\Rule;
use HarmonyIO\Validation\Rule\Type\CallableType;

class CallableTypeTest extends AsyncTestCase
{
    public function testRuleImplementsInterface(): void
    {
        $this->assertInstanceOf(Rule::class, new CallableType());
    }

    public function testValidateFailsWhenPassingAnInteger(): Generator
    {
        /** @var Result $result */
        $result = yield (new CallableType())->validate(1);

        $this->assertFalse($result->isValid());
        $this->assertSame('Type.CallableType', $result->getFirstError()->getMessage());
    }

    public function testValidateReturnsFalseWhenPassingAFloat(): Generator
    {
        /** @var Result $result */
        $result = yield (new CallableType())->validate(1.1);

        $this->assertFalse($result->isValid());
        $this->assertSame('Type.CallableType', $result->getFirstError()->getMessage());
    }

    public function testValidateReturnsTrueWhenPassingABoolean(): Generator
    {
        /** @var Result $result */
        $result = yield (new CallableType())->validate(true);

        $this->assertFalse($result->isValid());
        $this->assertSame('Type.CallableType', $result->getFirstError()->getMessage());
    }

    public function testValidateReturnsFalseWhenPassingAnArray(): Generator
    {
        /** @var Result $result */
        $result = yield (new CallableType())->validate([]);

        $this->assertFalse($result->isValid());
        $this->assertSame('Type.CallableType', $result->getFirstError()->getMessage());
    }

    public function testValidateReturnsFalseWhenPassingAnObject(): Generator
    {
        /** @var Result $result */
        $result = yield (new CallableType())->validate(new \DateTimeImmutable());

        $this->assertFalse($result->isValid());
        $this->assertSame('Type.CallableType', $result->getFirstError()->getMessage());
    }

    public function testValidateReturnsFalseWhenPassingNull(): Generator
    {
        /** @var Result $result */
        $result = yield (new CallableType())->validate(null);

        $this->assertFalse($result->isValid());
        $this->assertSame('Type.CallableType', $result->getFirstError()->getMessage());
    }

    public function testValidateReturnsFalseWhenPassingAResource(): Generator
    {
        $resource = fopen('php://memory', 'r');

        if ($resource === false) {
            $this->fail('Could not open the memory stream used for the test');

            return;
        }

        /** @var Result $result */
        $result = yield (new CallableType())->validate($resource);

        $this->assertFalse($result->isValid());
        $this->assertSame('Type.CallableType', $result->getFirstError()->getMessage());

        fclose($resource);
    }

    public function testValidateReturnsFalseWhenPassingAString(): Generator
    {
        /** @var Result $result */
        $result = yield (new CallableType())->validate('€');

        $this->assertFalse($result->isValid());
        $this->assertSame('Type.CallableType', $result->getFirstError()->getMessage());
    }

    public function testValidateSucceedsWhenPassingACallable(): Generator
    {
        /** @var Result $result */
        $result = yield (new CallableType())->validate(static function (): void {
        });

        $this->assertTrue($result->isValid());
        $this->assertNull($result->getFirstError());
    }
}
