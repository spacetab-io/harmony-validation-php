<?php declare(strict_types=1);

namespace HarmonyIO\ValidationTest\Unit\Exception;

use Amp\PHPUnit\AsyncTestCase;
use HarmonyIO\Validation\Exception\InvalidAspectRatio;

class InvalidAspectRatioTest extends AsyncTestCase
{
    public function testMessageIsFormattedCorrectly(): void
    {
        $typeException = new InvalidAspectRatio('Foo\\Bar');

        $this->assertSame(
            'The aspect ratio (`Foo\\Bar`) could not be parsed.',
            $typeException->getMessage()
        );
    }
}
