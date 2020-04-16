<?php declare(strict_types=1);

namespace HarmonyIO\ValidationTest\Unit\Rule\Network\Domain;

use Amp\Success;
use Generator;
use HarmonyIO\HttpClient\Client\Client;
use HarmonyIO\HttpClient\Message\CachingRequest;
use HarmonyIO\HttpClient\Message\Response;
use HarmonyIO\Validation\Result\Result;
use HarmonyIO\Validation\Rule\Network\Domain\Tld;
use HarmonyIO\ValidationTest\Unit\Rule\StringTestCase;
use PHPUnit\Framework\MockObject\MockObject;

class TldTest extends StringTestCase
{
    /** @var MockObject|Client */
    private $httpClient;

    /**
     * TldTest constructor.
     *
     * @param string|null $name
     * @param array<mixed> $data
     * @param mixed $dataName
     */
    public function __construct(?string $name = null, array $data = [], $dataName = '')
    {
        $this->httpClient = $this->createMock(Client::class);

        parent::__construct($name, $data, $dataName, Tld::class, $this->httpClient);
    }

    //phpcs:ignore SlevomatCodingStandard.TypeHints.TypeHintDeclaration.MissingReturnTypeHint
    public function setUp(): void
    {
        $this->httpClient = $this->createMock(Client::class);

        parent::setUp();
    }

    public function testValidateUsesCorrectUrl(): Generator
    {
        $this->httpClient
            ->method('request')
            ->willReturnCallback(function (CachingRequest $request) {
                $this->assertSame(
                    'https://data.iana.org/TLD/tlds-alpha-by-domain.txt',
                    (string) $request->getRequest()->getUri(),
                );

                $response = $this->createMock(Response::class);

                $response
                    ->method('getBody')
                    ->willReturn("FOO\nBAR\n")
                ;

                return new Success($response);
            })
        ;

        yield (new Tld($this->httpClient))->validate('tld');
    }

    public function testValidateStripsFirstLineFromResult(): Generator
    {
        $this->httpClient
            ->method('request')
            ->willReturnCallback(function (CachingRequest $request) {
                $this->assertSame(
                    'https://data.iana.org/TLD/tlds-alpha-by-domain.txt',
                    (string) $request->getRequest()->getUri(),
                );

                $response = $this->createMock(Response::class);

                $response
                    ->method('getBody')
                    ->willReturn("FOO\nBAR\n")
                ;

                return new Success($response);
            })
        ;

        /** @var Result $result */
        $result = yield (new Tld($this->httpClient))->validate('foo');

        $this->assertFalse($result->isValid());
        $this->assertSame('Network.Domain.Tld', $result->getFirstError()->getMessage());
    }

    public function testValidateStripsEmptyLastLineFromResult(): Generator
    {
        $this->httpClient
            ->method('request')
            ->willReturnCallback(function (CachingRequest $request) {
                $this->assertSame(
                    'https://data.iana.org/TLD/tlds-alpha-by-domain.txt',
                    (string) $request->getRequest()->getUri(),
                );

                $response = $this->createMock(Response::class);

                $response
                    ->method('getBody')
                    ->willReturn("FOO\nBAR\n")
                ;

                return new Success($response);
            })
        ;

        /** @var Result $result */
        $result = yield (new Tld($this->httpClient))->validate('');

        $this->assertFalse($result->isValid());
        $this->assertSame('Network.Domain.Tld', $result->getFirstError()->getMessage());
    }

    public function testValidateSucceedsOnExactCasingMatch(): Generator
    {
        $this->httpClient
            ->method('request')
            ->willReturnCallback(function (CachingRequest $request) {
                $this->assertSame(
                    'https://data.iana.org/TLD/tlds-alpha-by-domain.txt',
                    (string) $request->getRequest()->getUri(),
                );

                $response = $this->createMock(Response::class);

                $response
                    ->method('getBody')
                    ->willReturn("FOO\nBAR\n")
                ;

                return new Success($response);
            })
        ;

        /** @var Result $result */
        $result = yield (new Tld($this->httpClient))->validate('BAR');

        $this->assertTrue($result->isValid());
        $this->assertNull($result->getFirstError());
    }

    public function testValidateSucceedsOnLowerCasingMatch(): Generator
    {
        $this->httpClient
            ->method('request')
            ->willReturnCallback(function (CachingRequest $request) {
                $this->assertSame(
                    'https://data.iana.org/TLD/tlds-alpha-by-domain.txt',
                    (string) $request->getRequest()->getUri(),
                );

                $response = $this->createMock(Response::class);

                $response
                    ->method('getBody')
                    ->willReturn("FOO\nBAR\n")
                ;

                return new Success($response);
            })
        ;

        /** @var Result $result */
        $result = yield (new Tld($this->httpClient))->validate('bar');

        $this->assertTrue($result->isValid());
        $this->assertNull($result->getFirstError());
    }
}
