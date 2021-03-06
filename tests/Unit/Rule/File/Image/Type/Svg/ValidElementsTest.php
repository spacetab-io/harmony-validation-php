<?php declare(strict_types=1);

namespace HarmonyIO\ValidationTest\Unit\Rule\File\Image\Type\Svg;

use HarmonyIO\Validation\Result\Result;
use HarmonyIO\Validation\Rule\File\Image\Type\Svg\ValidElements;
use HarmonyIO\ValidationTest\Unit\Rule\FileTestCase;

class ValidElementsTest extends FileTestCase
{
    /**
     * @param mixed[] $data
     */
    public function __construct(?string $name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName, ValidElements::class);
    }

    public function testValidateFailsWhenNotMatchingMimeType()
    {
        /** @var Result $result */
        $result = yield (new ValidElements())->validate(TEST_DATA_DIR . '/image/mspaint.gif');

        $this->assertFalse($result->isValid());
        $this->assertSame('File.MimeType', $result->getFirstError()->getMessage());
        $this->assertSame('mimeType', $result->getFirstError()->getParameters()[0]->getKey());
        $this->assertSame('image/svg', $result->getFirstError()->getParameters()[0]->getValue());
    }

    public function testValidateFailsWhenImageContainsBrokenXml()
    {
        /** @var Result $result */
        $result = yield (new ValidElements())->validate(TEST_DATA_DIR . '/image/broken.svg');

        $this->assertFalse($result->isValid());
        $this->assertSame('File.Image.Type.Svg.ValidElements', $result->getFirstError()->getMessage());
    }

    public function testValidateFailsWhenImageContainsInvalidElements()
    {
        /** @var Result $result */
        $result = yield (new ValidElements())->validate(TEST_DATA_DIR . '/image/invalid-elements.svg');

        $this->assertFalse($result->isValid());
        $this->assertSame('File.Image.Type.Svg.ValidElements', $result->getFirstError()->getMessage());
    }

    public function testValidateSucceedsWhenImageIsValid()
    {
        /** @var Result $result */
        $result = yield (new ValidElements())->validate(TEST_DATA_DIR . '/image/example.svg');

        $this->assertTrue($result->isValid());
        $this->assertNull($result->getFirstError());
    }
}
