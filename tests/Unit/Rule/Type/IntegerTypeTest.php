<?php declare(strict_types=1);

namespace HarmonyIO\ValidationTest\Unit\Rule\Type;

use Amp\PHPUnit\AsyncTestCase;
use Generator;
use HarmonyIO\Validation\Result\Result;
use HarmonyIO\Validation\Rule\Rule;
use HarmonyIO\Validation\Rule\Type\IntegerType;

class IntegerTypeTest extends AsyncTestCase
{
    public function testRuleImplementsInterface(): void
    {
        $this->assertInstanceOf(Rule::class, new IntegerType());
    }

    public function testValidateFailsWhenPassingAFloat(): Generator
    {
        /** @var Result $result */
        $result = yield (new IntegerType())->validate(1.1);

        $this->assertFalse($result->isValid());
        $this->assertSame('Type.IntegerType', $result->getFirstError()->getMessage());
    }

    public function testValidateReturnsTrueWhenPassingABoolean(): Generator
    {
        /** @var Result $result */
        $result = yield (new IntegerType())->validate(true);

        $this->assertFalse($result->isValid());
        $this->assertSame('Type.IntegerType', $result->getFirstError()->getMessage());
    }

    public function testValidateFailsWhenPassingAnArray(): Generator
    {
        /** @var Result $result */
        $result = yield (new IntegerType())->validate([]);

        $this->assertFalse($result->isValid());
        $this->assertSame('Type.IntegerType', $result->getFirstError()->getMessage());
    }

    public function testValidateFailsWhenPassingAnObject(): Generator
    {
        /** @var Result $result */
        $result = yield (new IntegerType())->validate(new \DateTimeImmutable());

        $this->assertFalse($result->isValid());
        $this->assertSame('Type.IntegerType', $result->getFirstError()->getMessage());
    }

    public function testValidateFailsWhenPassingNull(): Generator
    {
        /** @var Result $result */
        $result = yield (new IntegerType())->validate(null);

        $this->assertFalse($result->isValid());
        $this->assertSame('Type.IntegerType', $result->getFirstError()->getMessage());
    }

    public function testValidateFailsWhenPassingAResource(): Generator
    {
        $resource = fopen('php://memory', 'r');

        if ($resource === false) {
            $this->fail('Could not open the memory stream used for the test');

            return;
        }

        /** @var Result $result */
        $result = yield (new IntegerType())->validate($resource);

        $this->assertFalse($result->isValid());
        $this->assertSame('Type.IntegerType', $result->getFirstError()->getMessage());

        fclose($resource);
    }

    public function testValidateFailsWhenPassingACallable(): Generator
    {
        /** @var Result $result */
        $result = yield (new IntegerType())->validate(static function (): void {
        });

        $this->assertFalse($result->isValid());
        $this->assertSame('Type.IntegerType', $result->getFirstError()->getMessage());
    }

    public function testValidateFailsWhenPassingAString(): Generator
    {
        /** @var Result $result */
        $result = yield (new IntegerType())->validate('€');

        $this->assertFalse($result->isValid());
        $this->assertSame('Type.IntegerType', $result->getFirstError()->getMessage());
    }

    public function testValidateSucceedsWhenPassingAnInteger(): Generator
    {
        /** @var Result $result */
        $result = yield (new IntegerType())->validate(1);

        $this->assertTrue($result->isValid());
        $this->assertNull($result->getFirstError());
    }
}
