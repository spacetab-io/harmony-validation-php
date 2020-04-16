<?php declare(strict_types=1);

namespace HarmonyIO\ValidationTest\Unit\Rule;

use Generator;
use HarmonyIO\Validation\Result\Result;

class FileTestCase extends StringTestCase
{
    public function testValidateFailsWhenFileDoesNotExists(): Generator
    {
        /** @var Result $result */
        $result = yield $this->testObject->validate(TEST_DATA_DIR . '/unknown-file.txt');

        $this->assertFalse($result->isValid());
        $this->assertSame('FileSystem.File', $result->getFirstError()->getMessage());
    }

    public function testValidateFailsWhenPassingADirectory(): Generator
    {
        /** @var Result $result */
        $result = yield $this->testObject->validate(TEST_DATA_DIR . '/file-system/existing');

        $this->assertFalse($result->isValid());
        $this->assertSame('FileSystem.File', $result->getFirstError()->getMessage());
    }
}
