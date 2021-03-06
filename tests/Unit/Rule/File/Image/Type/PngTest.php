<?php declare(strict_types=1);

namespace HarmonyIO\ValidationTest\Unit\Rule\File\Image\Type;

use HarmonyIO\Validation\Result\Result;
use HarmonyIO\Validation\Rule\File\Image\Type\Png;
use HarmonyIO\ValidationTest\Unit\Rule\FileTestCase;

class PngTest extends FileTestCase
{
    /**
     * @param mixed[] $data
     */
    public function __construct(?string $name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName, Png::class);
    }

    public function testValidateFailsWhenNotMatchingMimeType()
    {
        /** @var Result $result */
        $result = yield (new Png())->validate(TEST_DATA_DIR . '/image/mspaint.gif');

        $this->assertFalse($result->isValid());
        $this->assertSame('File.MimeType', $result->getFirstError()->getMessage());
        $this->assertSame('mimeType', $result->getFirstError()->getParameters()[0]->getKey());
        $this->assertSame('image/png', $result->getFirstError()->getParameters()[0]->getValue());
    }

    public function testValidateFailsWhenImageIsCorrupted()
    {
        /** @var Result $result */
        $result = yield (new Png())->validate(TEST_DATA_DIR . '/image/broken-mspaint.png');

        $this->assertFalse($result->isValid());
        $this->assertSame('File.Image.Type.Png', $result->getFirstError()->getMessage());
    }

    public function testValidateSucceedsWhenImageIsValid()
    {
        /** @var Result $result */
        $result = yield (new Png())->validate(TEST_DATA_DIR . '/image/mspaint.png');

        $this->assertTrue($result->isValid());
        $this->assertNull($result->getFirstError());
    }
}
