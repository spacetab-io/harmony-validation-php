<?php declare(strict_types=1);

namespace HarmonyIO\ValidationTest\Unit\Rule\Type;

use Amp\PHPUnit\AsyncTestCase;
use Generator;
use HarmonyIO\Validation\Result\Result;
use HarmonyIO\Validation\Rule\Rule;
use HarmonyIO\Validation\Rule\Type\ArrayType;

class ArrayTypeTest extends AsyncTestCase
{
    public function testRuleImplementsInterface(): void
    {
        $this->assertInstanceOf(Rule::class, new ArrayType());
    }

    public function testValidateFailsWhenPassingAnInteger(): Generator
    {
        /** @var Result $result */
        $result = yield (new ArrayType())->validate(1);

        $this->assertFalse($result->isValid());
        $this->assertSame('Type.ArrayType', $result->getFirstError()->getMessage());
    }

    public function testValidateFailsWhenPassingAFloat(): Generator
    {
        /** @var Result $result */
        $result = yield (new ArrayType())->validate(1.1);

        $this->assertFalse($result->isValid());
        $this->assertSame('Type.ArrayType', $result->getFirstError()->getMessage());
    }

    public function testValidateFailsWhenPassingABoolean(): Generator
    {
        /** @var Result $result */
        $result = yield (new ArrayType())->validate(true);

        $this->assertFalse($result->isValid());
        $this->assertSame('Type.ArrayType', $result->getFirstError()->getMessage());
    }

    public function testValidateFailsWhenPassingAnObject(): Generator
    {
        /** @var Result $result */
        $result = yield (new ArrayType())->validate(new \DateTimeImmutable());

        $this->assertFalse($result->isValid());
        $this->assertSame('Type.ArrayType', $result->getFirstError()->getMessage());
    }

    public function testValidateFailsWhenPassingNull(): Generator
    {
        /** @var Result $result */
        $result = yield (new ArrayType())->validate(null);

        $this->assertFalse($result->isValid());
        $this->assertSame('Type.ArrayType', $result->getFirstError()->getMessage());
    }

    public function testValidateFailsWhenPassingAResource(): Generator
    {
        $resource = fopen('php://memory', 'r');

        if ($resource === false) {
            $this->fail('Could not open the memory stream used for the test');

            return;
        }

        /** @var Result $result */
        $result = yield (new ArrayType())->validate($resource);

        $this->assertFalse($result->isValid());
        $this->assertSame('Type.ArrayType', $result->getFirstError()->getMessage());

        fclose($resource);
    }

    public function testValidateFailsWhenPassingACallable(): Generator
    {
        /** @var Result $result */
        $result = yield (new ArrayType())->validate(static function (): void {
        });

        $this->assertFalse($result->isValid());
        $this->assertSame('Type.ArrayType', $result->getFirstError()->getMessage());
    }

    public function testValidateFailsWhenPassingAString(): Generator
    {
        /** @var Result $result */
        $result = yield (new ArrayType())->validate('€');

        $this->assertFalse($result->isValid());
        $this->assertSame('Type.ArrayType', $result->getFirstError()->getMessage());
    }

    public function testValidateSucceedsWhenPassingAnArray(): Generator
    {
        /** @var Result $result */
        $result = yield (new ArrayType())->validate([]);

        $this->assertTrue($result->isValid());
        $this->assertNull($result->getFirstError());
    }
}
