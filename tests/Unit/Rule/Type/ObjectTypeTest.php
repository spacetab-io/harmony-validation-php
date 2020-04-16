<?php declare(strict_types=1);

namespace HarmonyIO\ValidationTest\Unit\Rule\Type;

use Amp\PHPUnit\AsyncTestCase;
use Generator;
use HarmonyIO\Validation\Result\Result;
use HarmonyIO\Validation\Rule\Rule;
use HarmonyIO\Validation\Rule\Type\ObjectType;

class ObjectTypeTest extends AsyncTestCase
{
    public function testRuleImplementsInterface()
    {
        $this->assertInstanceOf(Rule::class, new ObjectType());
    }

    public function testValidateFailsWhenPassingAnInteger(): Generator
    {
        /** @var Result $result */
        $result = yield (new ObjectType())->validate(1);

        $this->assertFalse($result->isValid());
        $this->assertSame('Type.ObjectType', $result->getFirstError()->getMessage());
    }

    public function testValidateFailsWhenPassingAFloat(): Generator
    {
        /** @var Result $result */
        $result = yield (new ObjectType())->validate(1.1);

        $this->assertFalse($result->isValid());
        $this->assertSame('Type.ObjectType', $result->getFirstError()->getMessage());
    }

    public function testValidateFailsWhenPassingABoolean(): Generator
    {
        /** @var Result $result */
        $result = yield (new ObjectType())->validate(true);

        $this->assertFalse($result->isValid());
        $this->assertSame('Type.ObjectType', $result->getFirstError()->getMessage());
    }

    public function testValidateFailsWhenPassingAnArray(): Generator
    {
        /** @var Result $result */
        $result = yield (new ObjectType())->validate([]);

        $this->assertFalse($result->isValid());
        $this->assertSame('Type.ObjectType', $result->getFirstError()->getMessage());
    }

    public function testValidateFailsWhenPassingNull(): Generator
    {
        /** @var Result $result */
        $result = yield (new ObjectType())->validate(null);

        $this->assertFalse($result->isValid());
        $this->assertSame('Type.ObjectType', $result->getFirstError()->getMessage());
    }

    public function testValidateFailsWhenPassingAResource(): Generator
    {
        $resource = fopen('php://memory', 'r');

        if ($resource === false) {
            $this->fail('Could not open the memory stream used for the test');

            return;
        }

        /** @var Result $result */
        $result = yield (new ObjectType())->validate($resource);

        $this->assertFalse($result->isValid());
        $this->assertSame('Type.ObjectType', $result->getFirstError()->getMessage());

        fclose($resource);
    }

    public function testValidateFailsWhenPassingAString(): Generator
    {
        /** @var Result $result */
        $result = yield (new ObjectType())->validate('€');

        $this->assertFalse($result->isValid());
        $this->assertSame('Type.ObjectType', $result->getFirstError()->getMessage());
    }

    public function testValidateSucceedsWhenPassingACallable(): Generator
    {
        /** @var Result $result */
        $result = yield (new ObjectType())->validate(static function (): void {
        });

        $this->assertTrue($result->isValid());
        $this->assertNull($result->getFirstError());
    }

    public function testValidateSucceedsWhenPassingAnObject(): Generator
    {
        /** @var Result $result */
        $result = yield (new ObjectType())->validate(new \DateTimeImmutable());

        $this->assertTrue($result->isValid());
        $this->assertNull($result->getFirstError());
    }
}
