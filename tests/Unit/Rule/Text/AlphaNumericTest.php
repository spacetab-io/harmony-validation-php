<?php declare(strict_types=1);

namespace HarmonyIO\ValidationTest\Unit\Rule\Text;

use HarmonyIO\PHPUnitExtension\TestCase;
use HarmonyIO\Validation\Rule\Rule;
use HarmonyIO\Validation\Rule\Text\AlphaNumeric;

class AlphaNumericTest extends TestCase
{
    public function testRuleImplementsInterface(): void
    {
        $this->assertInstanceOf(Rule::class, new AlphaNumeric());
    }

    public function testValidateReturnsFalseWhenPassingAnInteger(): void
    {
        $this->assertFalse((new AlphaNumeric())->validate(1));
    }

    public function testValidateReturnsFalseWhenPassingAFloat(): void
    {
        $this->assertFalse((new AlphaNumeric())->validate(1.1));
    }

    public function testValidateReturnsFalseWhenPassingABoolean(): void
    {
        $this->assertFalse((new AlphaNumeric())->validate(true));
    }

    public function testValidateReturnsFalseWhenPassingAnArray(): void
    {
        $this->assertFalse((new AlphaNumeric())->validate([]));
    }

    public function testValidateReturnsFalseWhenPassingAnObject(): void
    {
        $this->assertFalse((new AlphaNumeric())->validate(new \DateTimeImmutable()));
    }

    public function testValidateReturnsFalseWhenPassingNull(): void
    {
        $this->assertFalse((new AlphaNumeric())->validate(null));
    }

    public function testValidateReturnsFalseWhenPassingAResource(): void
    {
        $resource = fopen('php://memory', 'r');

        if ($resource === false) {
            $this->fail('Could not open the memory stream used for the test');

            return;
        }

        $this->assertFalse((new AlphaNumeric())->validate($resource));

        fclose($resource);
    }

    public function testValidateReturnsFalseWhenPassingACallable(): void
    {
        $this->assertFalse((new AlphaNumeric())->validate(static function (): void {
        }));
    }

    public function testValidateReturnsTrueWhenPassingAnAlphaNumericalString(): void
    {
        $this->assertTrue((new AlphaNumeric())->validate('sdakjhsakh3287632786378'));
    }

    public function testValidateReturnsFalseWhenPassingANonAlphaNumericalString(): void
    {
        $this->assertFalse((new AlphaNumeric())->validate(' sdakjhsakh3287632786378'));
    }
}