<?php declare(strict_types=1);

namespace HarmonyIO\ValidationTest\Unit\Rule\File\Image;

use HarmonyIO\Validation\Result\Result;
use HarmonyIO\Validation\Rule\File\Image\MaximumWidth;
use HarmonyIO\ValidationTest\Unit\Rule\FileTestCase;

class MaximumWidthTest extends FileTestCase
{
    /**
     * @param mixed[] $data
     */
    public function __construct(?string $name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName, MaximumWidth::class, 200);
    }

    public function testValidateFailsWhenPassingAnUnsupportedImage()
    {
        /** @var Result $result */
        $result = yield (new MaximumWidth(200))->validate(TEST_DATA_DIR . '/file-mimetype-test.txt');

        $this->assertFalse($result->isValid());
        $this->assertSame('File.Image.Image', $result->getFirstError()->getMessage());
    }

    public function testValidateFailsWhenPassingAnImageWhichIsLargerThanTheMaximum()
    {
        /** @var Result $result */
        $result = yield (new MaximumWidth(199))->validate(TEST_DATA_DIR . '/image/200x400.png');

        $this->assertFalse($result->isValid());
        $this->assertSame('File.Image.MaximumWidth', $result->getFirstError()->getMessage());
        $this->assertSame('width', $result->getFirstError()->getParameters()[0]->getKey());
        $this->assertSame(199, $result->getFirstError()->getParameters()[0]->getValue());
    }

    public function testValidateSucceedsWhenPassingAnImageWhichExactlyMatchesTheMaximum()
    {
        /** @var Result $result */
        $result = yield (new MaximumWidth(200))->validate(TEST_DATA_DIR . '/image/200x400.png');

        $this->assertTrue($result->isValid());
        $this->assertNull($result->getFirstError());
    }

    public function testValidateSucceedsWhenPassingAnImageWhichIsSmallerThanTheMaximum()
    {
        /** @var Result $result */
        $result = yield (new MaximumWidth(201))->validate(TEST_DATA_DIR . '/image/200x400.png');

        $this->assertTrue($result->isValid());
        $this->assertNull($result->getFirstError());
    }
}
