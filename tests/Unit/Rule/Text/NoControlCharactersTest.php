<?php declare(strict_types=1);

namespace HarmonyIO\ValidationTest\Unit\Rule\Text;

use Generator;
use HarmonyIO\Validation\Result\Result;
use HarmonyIO\Validation\Rule\Text\NoControlCharacters;
use HarmonyIO\ValidationTest\Unit\Rule\StringTestCase;

class NoControlCharactersTest extends StringTestCase
{
    /**
     * NoControlCharactersTest constructor.
     *
     * @param string|null $name
     * @param array<mixed> $data
     * @param string $dataName
     */
    public function __construct(?string $name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName, NoControlCharacters::class, 10);
    }

    public function testValidateFailsWhenPassingAStringContainingControlCharacters(): Generator
    {
        /** @var Result $result */
        $result = yield (new NoControlCharacters())->validate('€€€€€€€€€' . chr(0));

        $this->assertFalse($result->isValid());
        $this->assertSame('Text.NoControlCharacters', $result->getFirstError()->getMessage());
    }

    public function testValidateSucceedsWhenPassingAStringWithoutControlCharacters(): Generator
    {
        /** @var Result $result */
        $result = yield (new NoControlCharacters())->validate('€€€€€€€€€€€');

        $this->assertTrue($result->isValid());
        $this->assertNull($result->getFirstError());
    }
}
