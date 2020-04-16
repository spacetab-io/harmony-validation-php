<?php declare(strict_types=1);

namespace HarmonyIO\ValidationTest\Unit\Rule\Type;

use Amp\PHPUnit\AsyncTestCase;
use Generator;
use HarmonyIO\Validation\Exception\InvalidFullyQualifiedClassOrInterfaceName;
use HarmonyIO\Validation\Result\Result;
use HarmonyIO\Validation\Rule\Rule;
use HarmonyIO\Validation\Rule\Type\InstanceOfType;

class InstanceofTypeTest extends AsyncTestCase
{
    public function testRuleImplementsInterface(): void
    {
        $this->assertInstanceOf(Rule::class, new InstanceOfType(\DateTimeImmutable::class));
    }

    public function testConstructorThrowsWhenPassingAnInvalidFullyQualifiedClassName(): void
    {
        $this->expectException(InvalidFullyQualifiedClassOrInterfaceName::class);

        new InstanceOfType('Foo\\Bar');
    }

    public function testValidateFailsWhenPassingAnInteger(): Generator
    {
        /** @var Result $result */
        $result = yield (new InstanceOfType(\DateTimeImmutable::class))->validate(1);

        $this->assertFalse($result->isValid());
        $this->assertSame('Type.InstanceOfType', $result->getFirstError()->getMessage());
        $this->assertSame('type', $result->getFirstError()->getParameters()[0]->getKey());
        $this->assertSame('integer', $result->getFirstError()->getParameters()[0]->getValue());
    }

    public function testValidateFailsWhenPassingAFloat(): Generator
    {
        /** @var Result $result */
        $result = yield (new InstanceOfType(\DateTimeImmutable::class))->validate(1.1);

        $this->assertFalse($result->isValid());
        $this->assertSame('Type.InstanceOfType', $result->getFirstError()->getMessage());
        $this->assertSame('type', $result->getFirstError()->getParameters()[0]->getKey());
        $this->assertSame('double', $result->getFirstError()->getParameters()[0]->getValue());
    }

    public function testValidateFailsWhenPassingABoolean(): Generator
    {
        /** @var Result $result */
        $result = yield (new InstanceOfType(\DateTimeImmutable::class))->validate(true);

        $this->assertFalse($result->isValid());
        $this->assertSame('Type.InstanceOfType', $result->getFirstError()->getMessage());
        $this->assertSame('type', $result->getFirstError()->getParameters()[0]->getKey());
        $this->assertSame('boolean', $result->getFirstError()->getParameters()[0]->getValue());
    }

    public function testValidateFailsWhenPassingAnArray(): Generator
    {
        /** @var Result $result */
        $result = yield (new InstanceOfType(\DateTimeImmutable::class))->validate([]);

        $this->assertFalse($result->isValid());
        $this->assertSame('Type.InstanceOfType', $result->getFirstError()->getMessage());
        $this->assertSame('type', $result->getFirstError()->getParameters()[0]->getKey());
        $this->assertSame('array', $result->getFirstError()->getParameters()[0]->getValue());
    }

    public function testValidateFailsWhenPassingNull(): Generator
    {
        /** @var Result $result */
        $result = yield (new InstanceOfType(\DateTimeImmutable::class))->validate(null);

        $this->assertFalse($result->isValid());
        $this->assertSame('Type.InstanceOfType', $result->getFirstError()->getMessage());
        $this->assertSame('type', $result->getFirstError()->getParameters()[0]->getKey());
        $this->assertSame('NULL', $result->getFirstError()->getParameters()[0]->getValue());
    }

    public function testValidateFailsWhenPassingAResource(): Generator
    {
        $resource = fopen('php://memory', 'r');

        if ($resource === false) {
            $this->fail('Could not open the memory stream used for the test');

            return;
        }

        /** @var Result $result */
        $result = yield (new InstanceOfType(\DateTimeImmutable::class))->validate($resource);

        $this->assertFalse($result->isValid());
        $this->assertSame('Type.InstanceOfType', $result->getFirstError()->getMessage());
        $this->assertSame('type', $result->getFirstError()->getParameters()[0]->getKey());
        $this->assertSame('resource', $result->getFirstError()->getParameters()[0]->getValue());

        fclose($resource);
    }

    public function testValidateFailsWhenPassingACallable(): Generator
    {
        /** @var Result $result */
        $result = yield (new InstanceOfType(\DateTimeImmutable::class))->validate(static function (): void {
        });

        $this->assertFalse($result->isValid());
        $this->assertSame('Type.InstanceOfType', $result->getFirstError()->getMessage());
        $this->assertSame('type', $result->getFirstError()->getParameters()[0]->getKey());
        $this->assertSame('Closure', $result->getFirstError()->getParameters()[0]->getValue());
    }

    public function testValidateFailsWhenPassingAString(): Generator
    {
        /** @var Result $result */
        $result = yield (new InstanceOfType(\DateTimeImmutable::class))->validate('€');

        $this->assertFalse($result->isValid());
        $this->assertSame('Type.InstanceOfType', $result->getFirstError()->getMessage());
        $this->assertSame('type', $result->getFirstError()->getParameters()[0]->getKey());
        $this->assertSame('string', $result->getFirstError()->getParameters()[0]->getValue());
    }

    public function testValidateSucceedsWhenPassingAnObjectMatchedAgainstSelf(): Generator
    {
        /** @var Result $result */
        $result = yield (new InstanceOfType(\DateTimeImmutable::class))->validate(new \DateTimeImmutable());

        $this->assertTrue($result->isValid());
        $this->assertNull($result->getFirstError());
    }

    public function testValidateSucceedsWhenPassingAnObjectMatchedAgainstParent(): Generator
    {
        /** @var Result $result */
        $result = yield (new InstanceOfType(\ReflectionFunctionAbstract::class))->validate(new \ReflectionFunction('strlen'));

        $this->assertTrue($result->isValid());
        $this->assertNull($result->getFirstError());
    }

    public function testValidateSucceedsWhenPassingAnObjectMatchedAgainstInterface(): Generator
    {
        /** @var Result $result */
        $result = yield (new InstanceOfType(\DateTimeInterface::class))->validate(new \DateTimeImmutable());

        $this->assertTrue($result->isValid());
        $this->assertNull($result->getFirstError());
    }
}
