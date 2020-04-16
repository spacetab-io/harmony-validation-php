<?php declare(strict_types=1);

namespace HarmonyIO\ValidationTest\Unit\Rule\File;

use HarmonyIO\Validation\Result\Result;
use HarmonyIO\Validation\Rule\File\MaximumSize;
use HarmonyIO\ValidationTest\Unit\Rule\FileTestCase;

class MaximumSizeTest extends FileTestCase
{
    /**
     * @param mixed[] $data
     */
    public function __construct(?string $name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName, MaximumSize::class, 6);
    }

    public function testValidateFailsWhenFileIsLargerThanMaximumSize()
    {
        /** @var Result $result */
        $result = yield (new MaximumSize(5))->validate(TEST_DATA_DIR . '/file-size-test-6b.txt');

        $this->assertFalse($result->isValid());
        $this->assertSame('File.MaximumSize', $result->getFirstError()->getMessage());
        $this->assertSame('size', $result->getFirstError()->getParameters()[0]->getKey());
        $this->assertSame(5, $result->getFirstError()->getParameters()[0]->getValue());
    }

    public function testValidateSucceedsWhenFileIsExactlyMaximumSize()
    {
        /** @var Result $result */
        $result = yield (new MaximumSize(6))->validate(TEST_DATA_DIR . '/file-size-test-6b.txt');

        $this->assertTrue($result->isValid());
        $this->assertNull($result->getFirstError());
    }

    public function testValidateSucceedsWhenFileIsSmallerThanMaximumSize()
    {
        /** @var Result $result */
        $result = yield (new MaximumSize(7))->validate(TEST_DATA_DIR . '/file-size-test-6b.txt');

        $this->assertTrue($result->isValid());
        $this->assertNull($result->getFirstError());
    }
}
