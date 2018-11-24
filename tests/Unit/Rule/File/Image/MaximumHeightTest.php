<?php declare(strict_types=1);

namespace HarmonyIO\ValidationTest\Unit\Rule\File\Image;

use HarmonyIO\PHPUnitExtension\TestCase;
use HarmonyIO\Validation\Rule\File\Image\MaximumHeight;
use HarmonyIO\Validation\Rule\Rule;

class MaximumHeightTest extends TestCase
{
    public function testRuleImplementsInterface(): void
    {
        $this->assertInstanceOf(Rule::class, new MaximumHeight(400));
    }

    public function testValidateReturnsFalseWhenPassingAnInteger(): void
    {
        $this->assertFalse((new MaximumHeight(400))->validate(1));
    }

    public function testValidateReturnsFalseWhenPassingAFloat(): void
    {
        $this->assertFalse((new MaximumHeight(400))->validate(1.1));
    }

    public function testValidateReturnsFalseWhenPassingABoolean(): void
    {
        $this->assertFalse((new MaximumHeight(400))->validate(true));
    }

    public function testValidateReturnsFalseWhenPassingAnArray(): void
    {
        $this->assertFalse((new MaximumHeight(400))->validate([]));
    }

    public function testValidateReturnsFalseWhenPassingAnObject(): void
    {
        $this->assertFalse((new MaximumHeight(400))->validate(new \DateTimeImmutable()));
    }

    public function testValidateReturnsFalseWhenPassingNull(): void
    {
        $this->assertFalse((new MaximumHeight(400))->validate(null));
    }

    public function testValidateReturnsFalseWhenPassingAResource(): void
    {
        $resource = fopen('php://memory', 'r');

        if ($resource === false) {
            $this->fail('Could not open the memory stream used for the test');

            return;
        }

        $this->assertFalse((new MaximumHeight(400))->validate($resource));

        fclose($resource);
    }

    public function testValidateReturnsFalseWhenPassingACallable(): void
    {
        $this->assertFalse((new MaximumHeight(400))->validate(static function (): void {
        }));
    }

    public function testValidateReturnsFalseWhenPassingAnNonExistentImage(): void
    {
        $this->assertFalse((new MaximumHeight(400))->validate(TEST_DATA_DIR . '/unknown-file.txt'));
    }

    public function testValidateReturnsTrueWhenPassingAnUnsupportedImage(): void
    {
        $this->assertFalse((new MaximumHeight(400))->validate(TEST_DATA_DIR . '/image/file-mime-type-test.txt'));
    }

    public function testValidateReturnsTrueWhenPassingAnImageWhichExactlyMatchesTheMaximum(): void
    {
        $this->assertTrue((new MaximumHeight(400))->validate(TEST_DATA_DIR . '/image/200x400.png'));
    }

    public function testValidateReturnsTrueWhenPassingAnImageWhichIsSmallerThanTheMaximum(): void
    {
        $this->assertTrue((new MaximumHeight(401))->validate(TEST_DATA_DIR . '/image/200x400.png'));
    }

    public function testValidateReturnsFalseWhenPassingAnImageWhichIsLargerThanTheMaximum(): void
    {
        $this->assertFalse((new MaximumHeight(399))->validate(TEST_DATA_DIR . '/image/200x400.png'));
    }
}
