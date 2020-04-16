<?php declare(strict_types=1);

namespace HarmonyIO\ValidationTest\Unit\Rule\Type;

use Amp\PHPUnit\AsyncTestCase;
use Generator;
use HarmonyIO\Validation\Result\Result;
use HarmonyIO\Validation\Rule\Rule;
use HarmonyIO\Validation\Rule\Type\ResourceType;

class ResourceTypeTest extends AsyncTestCase
{
    public function testRuleImplementsInterface(): void
    {
        $this->assertInstanceOf(Rule::class, new ResourceType());
    }

    public function testValidateFailsWhenPassingAnInteger(): Generator
    {
        /** @var Result $result */
        $result = yield (new ResourceType())->validate(1);

        $this->assertFalse($result->isValid());
        $this->assertSame('Type.ResourceType', $result->getFirstError()->getMessage());
    }

    public function testValidateFailsWhenPassingAFloat(): Generator
    {
        /** @var Result $result */
        $result = yield (new ResourceType())->validate(1.1);

        $this->assertFalse($result->isValid());
        $this->assertSame('Type.ResourceType', $result->getFirstError()->getMessage());
    }

    public function testValidateFailsWhenPassingABoolean(): Generator
    {
        /** @var Result $result */
        $result = yield (new ResourceType())->validate(true);

        $this->assertFalse($result->isValid());
        $this->assertSame('Type.ResourceType', $result->getFirstError()->getMessage());
    }

    public function testValidateFailsWhenPassingAnArray(): Generator
    {
        /** @var Result $result */
        $result = yield (new ResourceType())->validate([]);

        $this->assertFalse($result->isValid());
        $this->assertSame('Type.ResourceType', $result->getFirstError()->getMessage());
    }

    public function testValidateFailsWhenPassingAnObject(): Generator
    {
        /** @var Result $result */
        $result = yield (new ResourceType())->validate(new \DateTimeImmutable());

        $this->assertFalse($result->isValid());
        $this->assertSame('Type.ResourceType', $result->getFirstError()->getMessage());
    }

    public function testValidateFailsWhenPassingNull(): Generator
    {
        /** @var Result $result */
        $result = yield (new ResourceType())->validate(null);

        $this->assertFalse($result->isValid());
        $this->assertSame('Type.ResourceType', $result->getFirstError()->getMessage());
    }

    public function testValidateFailsWhenPassingACallable(): Generator
    {
        /** @var Result $result */
        $result = yield (new ResourceType())->validate(static function (): void {
        });

        $this->assertFalse($result->isValid());
        $this->assertSame('Type.ResourceType', $result->getFirstError()->getMessage());
    }

    public function testValidateFailsWhenPassingAString(): Generator
    {
        /** @var Result $result */
        $result = yield (new ResourceType())->validate('€');

        $this->assertFalse($result->isValid());
        $this->assertSame('Type.ResourceType', $result->getFirstError()->getMessage());
    }

    public function testValidateSucceedsWhenPassingAResource(): Generator
    {
        $resource = fopen('php://memory', 'r');

        if ($resource === false) {
            $this->fail('Could not open the memory stream used for the test');

            return;
        }

        /** @var Result $result */
        $result = yield (new ResourceType())->validate($resource);

        $this->assertTrue($result->isValid());
        $this->assertNull($result->getFirstError());

        fclose($resource);
    }
}
