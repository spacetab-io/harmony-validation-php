<?php declare(strict_types=1);

namespace HarmonyIO\ValidationTest\Unit\Rule\Type;

use Amp\PHPUnit\AsyncTestCase;
use Generator;
use HarmonyIO\Validation\Result\Result;
use HarmonyIO\Validation\Rule\Rule;
use HarmonyIO\Validation\Rule\Type\BooleanType;

class BooleanTypeTest extends AsyncTestCase
{
    public function testRuleImplementsInterface(): void
    {
        $this->assertInstanceOf(Rule::class, new BooleanType());
    }

    public function testValidateFailsWhenPassingAnInteger(): Generator
    {
        /** @var Result $result */
        $result = yield (new BooleanType())->validate(1);

        $this->assertFalse($result->isValid());
        $this->assertSame('Type.BooleanType', $result->getFirstError()->getMessage());
    }

    public function testValidateFailsWhenPassingAFloat(): Generator
    {
        /** @var Result $result */
        $result = yield (new BooleanType())->validate(1.1);

        $this->assertFalse($result->isValid());
        $this->assertSame('Type.BooleanType', $result->getFirstError()->getMessage());
    }

    public function testValidateFailsWhenPassingAnArray(): Generator
    {
        /** @var Result $result */
        $result = yield (new BooleanType())->validate([]);

        $this->assertFalse($result->isValid());
        $this->assertSame('Type.BooleanType', $result->getFirstError()->getMessage());
    }

    public function testValidateFailsWhenPassingAnObject(): Generator
    {
        /** @var Result $result */
        $result = yield (new BooleanType())->validate(new \DateTimeImmutable());

        $this->assertFalse($result->isValid());
        $this->assertSame('Type.BooleanType', $result->getFirstError()->getMessage());
    }

    public function testValidateFailsWhenPassingNull(): Generator
    {
        /** @var Result $result */
        $result = yield (new BooleanType())->validate(null);

        $this->assertFalse($result->isValid());
        $this->assertSame('Type.BooleanType', $result->getFirstError()->getMessage());
    }

    public function testValidateFailsWhenPassingAResource(): Generator
    {
        $resource = fopen('php://memory', 'r');

        if ($resource === false) {
            $this->fail('Could not open the memory stream used for the test');

            return;
        }

        /** @var Result $result */
        $result = yield (new BooleanType())->validate($resource);

        $this->assertFalse($result->isValid());
        $this->assertSame('Type.BooleanType', $result->getFirstError()->getMessage());

        fclose($resource);
    }

    public function testValidateFailsWhenPassingACallable(): Generator
    {
        /** @var Result $result */
        $result = yield (new BooleanType())->validate(static function (): void {
        });

        $this->assertFalse($result->isValid());
        $this->assertSame('Type.BooleanType', $result->getFirstError()->getMessage());
    }

    public function testValidateFailsWhenPassingAString(): Generator
    {
        /** @var Result $result */
        $result = yield (new BooleanType())->validate('€');

        $this->assertFalse($result->isValid());
        $this->assertSame('Type.BooleanType', $result->getFirstError()->getMessage());
    }

    public function testValidateSucceedsWhenPassingABoolean(): Generator
    {
        /** @var Result $result */
        $result = yield (new BooleanType())->validate(true);

        $this->assertTrue($result->isValid());
        $this->assertNull($result->getFirstError());
    }
}
