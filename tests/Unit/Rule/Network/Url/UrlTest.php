<?php declare(strict_types=1);

namespace HarmonyIO\ValidationTest\Unit\Rule\Network\Url;

use Generator;
use HarmonyIO\Validation\Result\Result;
use HarmonyIO\Validation\Rule\Network\Url\Url;
use HarmonyIO\ValidationTest\Unit\Rule\StringTestCase;

class UrlTest extends StringTestCase
{
    /**
     * UrlTest constructor.
     *
     * @param string|null $name
     * @param array<mixed> $data
     * @param string $dataName
     */
    public function __construct(?string $name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName, Url::class);
    }

    public function testValidateFailsWhenPassingAUrlWithoutProtocol(): Generator
    {
        /** @var Result $result */
        $result = yield (new Url())->validate('pieterhordijk.com');

        $this->assertFalse($result->isValid());
        $this->assertSame('Network.Url.Url', $result->getFirstError()->getMessage());
    }

    public function testValidateFailsWhenPassingAUrlWithoutHost(): Generator
    {
        /** @var Result $result */
        $result = yield (new Url())->validate('https://');

        $this->assertFalse($result->isValid());
        $this->assertSame('Network.Url.Url', $result->getFirstError()->getMessage());
    }

    public function testValidateSucceedsWhenPassingAValidUrl(): Generator
    {
        /** @var Result $result */
        $result = yield (new Url())->validate('https://pieterhordijk.com');

        $this->assertTrue($result->isValid());
        $this->assertNull($result->getFirstError());
    }

    public function testValidateSucceedsWhenPassingAValidUrlWithPort(): Generator
    {
        /** @var Result $result */
        $result = yield (new Url())->validate('https://pieterhordijk.com:1337');

        $this->assertTrue($result->isValid());
        $this->assertNull($result->getFirstError());
    }
}
