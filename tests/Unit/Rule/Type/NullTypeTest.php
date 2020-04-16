<?php declare(strict_types=1);

namespace HarmonyIO\ValidationTest\Unit\Rule\Type;

use Amp\PHPUnit\AsyncTestCase;
use Generator;
use HarmonyIO\Validation\Result\Result;
use HarmonyIO\Validation\Rule\Rule;
use HarmonyIO\Validation\Rule\Type\NullType;

class NullTypeTest extends AsyncTestCase
{
    public function testRuleImplementsInterface()
    {
        $this->assertInstanceOf(Rule::class, new NullType());
    }

    public function testValidateFailsWhenPassingAnInteger(): Generator
    {
        /** @var Result $result */
        $result = yield (new NullType())->validate(1);

        $this->assertFalse($result->isValid());
        $this->assertSame('Type.NullType', $result->getFirstError()->getMessage());
    }

    public function testValidateFailsWhenPassingAFloat(): Generator
    {
        /** @var Result $result */
        $result = yield (new NullType())->validate(1.1);

        $this->assertFalse($result->isValid());
        $this->assertSame('Type.NullType', $result->getFirstError()->getMessage());
    }

    public function testValidateFailsWhenPassingABoolean(): Generator
    {
        /** @var Result $result */
        $result = yield (new NullType())->validate(true);

        $this->assertFalse($result->isValid());
        $this->assertSame('Type.NullType', $result->getFirstError()->getMessage());
    }

    public function testValidateFailsWhenPassingAnArray(): Generator
    {
        /** @var Result $result */
        $result = yield (new NullType())->validate([]);

        $this->assertFalse($result->isValid());
        $this->assertSame('Type.NullType', $result->getFirstError()->getMessage());
    }

    public function testValidateFailsWhenPassingAnObject(): Generator
    {
        /** @var Result $result */
        $result = yield (new NullType())->validate(new \DateTimeImmutable());

        $this->assertFalse($result->isValid());
        $this->assertSame('Type.NullType', $result->getFirstError()->getMessage());
    }

    public function testValidateFailsWhenPassingAResource(): Generator
    {
        $resource = fopen('php://memory', 'r');

        if ($resource === false) {
            $this->fail('Could not open the memory stream used for the test');

            return;
        }

        /** @var Result $result */
        $result = yield (new NullType())->validate($resource);

        $this->assertFalse($result->isValid());
        $this->assertSame('Type.NullType', $result->getFirstError()->getMessage());

        fclose($resource);
    }

    public function testValidateFailsWhenPassingACallable(): Generator
    {
        /** @var Result $result */
        $result = yield (new NullType())->validate(static function () {
        });

        $this->assertFalse($result->isValid());
        $this->assertSame('Type.NullType', $result->getFirstError()->getMessage());
    }

    public function testValidateFailsWhenPassingAString(): Generator
    {
        /** @var Result $result */
        $result = yield (new NullType())->validate('€');

        $this->assertFalse($result->isValid());
        $this->assertSame('Type.NullType', $result->getFirstError()->getMessage());
    }

    public function testValidateSucceedsWhenPassingNull(): Generator
    {
        /** @var Result $result */
        $result = yield (new NullType())->validate(null);

        $this->assertTrue($result->isValid());
        $this->assertNull($result->getFirstError());
    }
}
