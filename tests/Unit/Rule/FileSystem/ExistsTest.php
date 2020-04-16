<?php declare(strict_types=1);

namespace HarmonyIO\ValidationTest\Unit\Rule\FileSystem;

use HarmonyIO\Validation\Result\Result;
use HarmonyIO\Validation\Rule\FileSystem\Exists;
use HarmonyIO\ValidationTest\Unit\Rule\StringTestCase;

class ExistsTest extends StringTestCase
{
    /**
     * @param mixed[] $data
     */
    public function __construct(?string $name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName, Exists::class);
    }

    public function testValidateFailsWhenPassingAnUnExistingPath()
    {
        /** @var Result $result */
        $result = yield (new Exists())->validate(TEST_DATA_DIR . '/unknown-file.txt');

        $this->assertFalse($result->isValid());
        $this->assertSame('FileSystem.Exists', $result->getFirstError()->getMessage());
    }

    public function testValidateSucceedsWhenPassingAnExistingDirectory()
    {
        /** @var Result $result */
        $result = yield (new Exists())->validate(TEST_DATA_DIR . '/file-system/existing');

        $this->assertTrue($result->isValid());
        $this->assertNull($result->getFirstError());
    }

    public function testValidateSucceedsWhenPassingAnExistingFile()
    {
        /** @var Result $result */
        $result = yield (new Exists())->validate(TEST_DATA_DIR . '/file-system/existing/existing.txt');

        $this->assertTrue($result->isValid());
        $this->assertNull($result->getFirstError());
    }
}
