<?php declare(strict_types=1);

namespace HarmonyIO\ValidationTest\Unit\Rule\File\Image;

use HarmonyIO\Validation\Result\Result;
use HarmonyIO\Validation\Rule\File\Image\Landscape;
use HarmonyIO\ValidationTest\Unit\Rule\FileTestCase;

class LandscapeTest extends FileTestCase
{
    /**
     * @param mixed[] $data
     */
    public function __construct(?string $name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName, Landscape::class);
    }

    public function testValidateFailsWhenPassingAnUnsupportedImage()
    {
        /** @var Result $result */
        $result = yield (new Landscape())->validate(TEST_DATA_DIR . '/file-mimetype-test.txt');

        $this->assertFalse($result->isValid());
        $this->assertSame('File.Image.Image', $result->getFirstError()->getMessage());
    }

    public function testValidateFailsWhenPassingAnImageWhichWidthIsTheSameAsItsHeight()
    {
        /** @var Result $result */
        $result = yield (new Landscape())->validate(TEST_DATA_DIR . '/image/400x400.png');

        $this->assertFalse($result->isValid());
        $this->assertSame('File.Image.Landscape', $result->getFirstError()->getMessage());
    }

    public function testValidateFailsWhenPassingAnImageWhichHeightIsBiggerThanItsWidth()
    {
        /** @var Result $result */
        $result = yield (new Landscape())->validate(TEST_DATA_DIR . '/image/200x400.png');

        $this->assertFalse($result->isValid());
        $this->assertSame('File.Image.Landscape', $result->getFirstError()->getMessage());
    }

    public function testValidateSucceedsWhenPassingAnImageWhichWidthIsBiggerThanItsHeight()
    {
        /** @var Result $result */
        $result = yield (new Landscape())->validate(TEST_DATA_DIR . '/image/400x200.png');

        $this->assertTrue($result->isValid());
        $this->assertNull($result->getFirstError());
    }
}
