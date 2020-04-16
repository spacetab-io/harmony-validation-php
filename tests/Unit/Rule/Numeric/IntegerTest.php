<?php declare(strict_types=1);

namespace HarmonyIO\ValidationTest\Unit\Rule\Numeric;

use Amp\PHPUnit\AsyncTestCase;
use Generator;
use HarmonyIO\Validation\Result\Result;
use HarmonyIO\Validation\Rule\Numeric\Integer;
use HarmonyIO\Validation\Rule\Rule;

class IntegerTest extends AsyncTestCase
{
    public function testRuleImplementsInterface()
    {
        $this->assertInstanceOf(Rule::class, new Integer());
    }

    public function testValidateFailsWhenPassingAFloat(): Generator
    {
        /** @var Result $result */
        $result = yield (new Integer())->validate(1.1);

        $this->assertFalse($result->isValid());
        $this->assertSame('Numeric.Integer', $result->getFirstError()->getMessage());
    }

    public function testValidateFailsWhenPassingABoolean(): Generator
    {
        /** @var Result $result */
        $result = yield (new Integer())->validate(true);

        $this->assertFalse($result->isValid());
        $this->assertSame('Numeric.Integer', $result->getFirstError()->getMessage());
    }

    public function testValidateFailsWhenPassingAnArray(): Generator
    {
        /** @var Result $result */
        $result = yield (new Integer())->validate([]);

        $this->assertFalse($result->isValid());
        $this->assertSame('Numeric.Integer', $result->getFirstError()->getMessage());
    }

    public function testValidateFailsWhenPassingAnObject(): Generator
    {
        /** @var Result $result */
        $result = yield (new Integer())->validate(new \DateTimeImmutable());

        $this->assertFalse($result->isValid());
        $this->assertSame('Numeric.Integer', $result->getFirstError()->getMessage());
    }

    public function testValidateFailsWhenPassingNull(): Generator
    {
        /** @var Result $result */
        $result = yield (new Integer())->validate(null);

        $this->assertFalse($result->isValid());
        $this->assertSame('Numeric.Integer', $result->getFirstError()->getMessage());
    }

    public function testValidateFailsWhenPassingAResource(): Generator
    {
        $resource = fopen('php://memory', 'r');

        if ($resource === false) {
            $this->fail('Could not open the memory stream used for the test');

            return;
        }

        /** @var Result $result */
        $result = yield (new Integer())->validate($resource);

        $this->assertFalse($result->isValid());
        $this->assertSame('Numeric.Integer', $result->getFirstError()->getMessage());

        fclose($resource);
    }

    public function testValidateFailsWhenPassingACallable(): Generator
    {
        /** @var Result $result */
        $result = yield (new Integer())->validate(static function (): void {
        });

        $this->assertFalse($result->isValid());
        $this->assertSame('Numeric.Integer', $result->getFirstError()->getMessage());
    }

    public function testValidateFailsWhenPassingAFloatAsAString(): Generator
    {
        /** @var Result $result */
        $result = yield (new Integer())->validate('1.1');

        $this->assertFalse($result->isValid());
        $this->assertSame('Numeric.Integer', $result->getFirstError()->getMessage());
    }

    public function testValidateSucceedsWhenPassingAnIntegerAsAString(): Generator
    {
        /** @var Result $result */
        $result = yield (new Integer())->validate('1');

        $this->assertTrue($result->isValid());
        $this->assertNull($result->getFirstError());
    }

    public function testValidateSucceedsWhenPassingAnInteger(): Generator
    {
        /** @var Result $result */
        $result = yield (new Integer())->validate(1);

        $this->assertTrue($result->isValid());
        $this->assertNull($result->getFirstError());
    }
}
