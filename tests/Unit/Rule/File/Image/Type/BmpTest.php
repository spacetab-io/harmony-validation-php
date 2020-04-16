<?php declare(strict_types=1);

namespace HarmonyIO\ValidationTest\Unit\Rule\File\Image\Type;

use HarmonyIO\Validation\Result\Result;
use HarmonyIO\Validation\Rule\File\Image\Type\Bmp;
use HarmonyIO\ValidationTest\Unit\Rule\FileTestCase;

class BmpTest extends FileTestCase
{
    /**
     * @param mixed[] $data
     */
    public function __construct(?string $name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName, Bmp::class);
    }

    public function testValidateFailsWhenNotMatchingMimeType()
    {
        /** @var Result $result */
        $result = yield (new Bmp())->validate(TEST_DATA_DIR . '/image/mspaint.gif');

        $this->assertFalse($result->isValid());
        $this->assertSame('File.Image.Type.Bmp', $result->getFirstError()->getMessage());
    }

    public function testValidateFailsWhenImageIsCorrupted()
    {
        /** @var Result $result */
        $result = yield (new Bmp())->validate(TEST_DATA_DIR . '/image/broken-mspaint.bmp');

        $this->assertFalse($result->isValid());
        $this->assertSame('File.Image.Type.Bmp', $result->getFirstError()->getMessage());
    }

    public function testValidateSucceedsWhenImageIsValid()
    {
        /** @var Result $result */
        $result = yield (new Bmp())->validate(TEST_DATA_DIR . '/image/mspaint.bmp');

        $this->assertTrue($result->isValid());
        $this->assertNull($result->getFirstError());
    }
}
