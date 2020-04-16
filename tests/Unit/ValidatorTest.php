<?php declare(strict_types=1);

namespace HarmonyIO\ValidationTest\Unit;

use Amp\PHPUnit\AsyncTestCase;
use Amp\Promise;
use Generator;
use HarmonyIO\Validation\Result\Result;
use HarmonyIO\Validation\Rule\Text\MinimumLength;
use HarmonyIO\Validation\Validator;

class ValidatorTest extends AsyncTestCase
{
    public function testValidateReturnsPromise(): void
    {
        $this->assertInstanceOf(
            Promise::class,
            (new Validator(new MinimumLength(3)))->validate('Test value'),
        );
    }

    public function testValidateFailsOnInvalidValidation(): Generator
    {
        /** @var Result $result */
        $result = yield (new Validator(new MinimumLength(20)))->validate('Test value');

        $this->assertFalse($result->isValid());
        $this->assertSame('Text.MinimumLength', $result->getFirstError()->getMessage());
        $this->assertSame('length', $result->getFirstError()->getParameters()[0]->getKey());
        $this->assertSame(20, $result->getFirstError()->getParameters()[0]->getValue());
    }

    public function testValidateSucceedsOnValidValidation(): Generator
    {
        /** @var Result $result */
        $result = yield (new Validator(new MinimumLength(3)))->validate('Test value');

        $this->assertTrue($result->isValid());
        $this->assertNull($result->getFirstError());
    }
}
