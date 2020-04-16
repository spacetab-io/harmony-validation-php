<?php declare(strict_types=1);

namespace HarmonyIO\ValidationTest\Unit\Rule\File\Image;

use HarmonyIO\Validation\Exception\InvalidAspectRatio;
use HarmonyIO\Validation\Result\Result;
use HarmonyIO\Validation\Rule\File\Image\AspectRatio;
use HarmonyIO\ValidationTest\Unit\Rule\FileTestCase;

class AspectRatioTest extends FileTestCase
{
    /**
     * @param mixed[] $data
     */
    public function __construct(?string $name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName, AspectRatio::class, '4:3');
    }

    public function testConstructorThrowsWhenPassingInAnInvalidAspectRatioString()
    {
        $this->expectException(InvalidAspectRatio::class);
        $this->expectExceptionMessage('The aspect ratio (`a:a`) could not be parsed.');

        new AspectRatio('a:a');
    }

    public function testValidateFailsWhenNotMatchingMimeType()
    {
        /** @var Result $result */
        $result = yield (new AspectRatio('4:3'))->validate(TEST_DATA_DIR . '/file-mimetype-test.txt');

        $this->assertFalse($result->isValid());
        $this->assertSame('File.Image.Image', $result->getFirstError()->getMessage());
    }

    public function testValidateFailsWhenPassingAnImageWithIncorrectAspectRatio()
    {
        /** @var Result $result */
        $result = yield (new AspectRatio('4:3'))->validate(TEST_DATA_DIR . '/image/aspect-ratio-16-9.png');

        $this->assertFalse($result->isValid());
        $this->assertSame('File.Image.AspectRatio', $result->getFirstError()->getMessage());
        $this->assertSame('ratio', $result->getFirstError()->getParameters()[0]->getKey());
        $this->assertSame('4:3', $result->getFirstError()->getParameters()[0]->getValue());
    }

    public function testValidateSucceedsWhenPassingAnImageWithCorrectAspectRatio()
    {
        /** @var Result $result */
        $result = yield (new AspectRatio('4:3'))->validate(TEST_DATA_DIR . '/image/aspect-ratio-4-3.png');

        $this->assertTrue($result->isValid());
        $this->assertNull($result->getFirstError());
    }
}
