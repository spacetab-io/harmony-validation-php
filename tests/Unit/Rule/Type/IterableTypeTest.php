<?php declare(strict_types=1);

namespace HarmonyIO\ValidationTest\Unit\Rule\Type;

use Amp\PHPUnit\AsyncTestCase;
use Generator;
use HarmonyIO\Validation\Result\Result;
use HarmonyIO\Validation\Rule\Rule;
use HarmonyIO\Validation\Rule\Type\IterableType;

class IterableTypeTest extends AsyncTestCase
{
    public function testRuleImplementsInterface(): void
    {
        $this->assertInstanceOf(Rule::class, new IterableType());
    }

    public function testValidateFailsWhenPassingAnInteger(): Generator
    {
        /** @var Result $result */
        $result = yield (new IterableType())->validate(1);

        $this->assertFalse($result->isValid());
        $this->assertSame('Type.IterableType', $result->getFirstError()->getMessage());
    }

    public function testValidateFailsWhenPassingAFloat(): Generator
    {
        /** @var Result $result */
        $result = yield (new IterableType())->validate(1.1);

        $this->assertFalse($result->isValid());
        $this->assertSame('Type.IterableType', $result->getFirstError()->getMessage());
    }

    public function testValidateFailsWhenPassingABoolean(): Generator
    {
        /** @var Result $result */
        $result = yield (new IterableType())->validate(true);

        $this->assertFalse($result->isValid());
        $this->assertSame('Type.IterableType', $result->getFirstError()->getMessage());
    }

    public function testValidateFailsWhenPassingAnObject(): Generator
    {
        /** @var Result $result */
        $result = yield (new IterableType())->validate(new \DateTimeImmutable());

        $this->assertFalse($result->isValid());
        $this->assertSame('Type.IterableType', $result->getFirstError()->getMessage());
    }

    public function testValidateFailsWhenPassingNull(): Generator
    {
        /** @var Result $result */
        $result = yield (new IterableType())->validate(null);

        $this->assertFalse($result->isValid());
        $this->assertSame('Type.IterableType', $result->getFirstError()->getMessage());
    }

    public function testValidateFailsWhenPassingAResource(): Generator
    {
        $resource = fopen('php://memory', 'r');

        if ($resource === false) {
            $this->fail('Could not open the memory stream used for the test');

            return;
        }

        /** @var Result $result */
        $result = yield (new IterableType())->validate($resource);

        $this->assertFalse($result->isValid());
        $this->assertSame('Type.IterableType', $result->getFirstError()->getMessage());

        fclose($resource);
    }

    public function testValidateFailsWhenPassingACallable(): Generator
    {
        /** @var Result $result */
        $result = yield (new IterableType())->validate(static function (): void {
        });

        $this->assertFalse($result->isValid());
        $this->assertSame('Type.IterableType', $result->getFirstError()->getMessage());
    }

    public function testValidateFailsWhenPassingAString(): Generator
    {
        /** @var Result $result */
        $result = yield (new IterableType())->validate('€');

        $this->assertFalse($result->isValid());
        $this->assertSame('Type.IterableType', $result->getFirstError()->getMessage());
    }

    public function testValidateSucceedsWhenPassingAnArray(): Generator
    {
        /** @var Result $result */
        $result = yield (new IterableType())->validate([]);

        $this->assertTrue($result->isValid());
        $this->assertNull($result->getFirstError());
    }
}
