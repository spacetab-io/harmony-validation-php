<?php declare(strict_types=1);

namespace HarmonyIO\ValidationTest\Unit\Rule\Network\Url;

use Amp\Dns\DnsException;
use Amp\Http\Client\Request;
use Amp\Success;
use Generator;
use HarmonyIO\HttpClient\Client\Client;
use HarmonyIO\HttpClient\Message\Response;
use HarmonyIO\Validation\Result\Result;
use HarmonyIO\Validation\Rule\Network\Url\OkResponse;
use HarmonyIO\ValidationTest\Unit\Rule\StringTestCase;
use PHPUnit\Framework\MockObject\MockObject;

class OkResponseTest extends StringTestCase
{
    /** @var MockObject|Client */
    private $httpClient;

    /**
     * OkResponseTest constructor.
     *
     * @param string|null $name
     * @param array<mixed> $data
     * @param string $dataName
     */
    public function __construct(?string $name = null, array $data = [], $dataName = '')
    {
        $this->httpClient = $this->createMock(Client::class);

        parent::__construct($name, $data, $dataName, OkResponse::class, $this->httpClient);
    }

    //phpcs:ignore SlevomatCodingStandard.TypeHints.TypeHintDeclaration.MissingReturnTypeHint
    public function setUp(): void
    {
        $this->httpClient = $this->createMock(Client::class);

        parent::setUp();
    }

    public function testValidateFailsWhenPassingAUrlWithoutProtocol(): Generator
    {
        /** @var Result $result */
        $result = yield (new OkResponse($this->httpClient))->validate('pieterhordijk.com');

        $this->assertFalse($result->isValid());
        $this->assertSame('Network.Url.Url', $result->getFirstError()->getMessage());
    }

    public function testValidateFailsWhenPassingAUrlWithoutHost(): Generator
    {
        /** @var Result $result */
        $result = yield (new OkResponse($this->httpClient))->validate('https://');

        $this->assertFalse($result->isValid());
        $this->assertSame('Network.Url.Url', $result->getFirstError()->getMessage());
    }

    public function testValidatePassesUrlToClient(): Generator
    {
        $this->httpClient
            ->method('request')
            ->willReturnCallback(function (Request $request) {
                $this->assertSame('https://pieterhordijk.com', (string) $request->getUri());

                $response = $this->createMock(Response::class);

                $response
                    ->method('getBody')
                    ->willReturn('foo')
                ;

                return new Success($response);
            })
        ;

        yield (new OkResponse($this->httpClient))->validate('https://pieterhordijk.com');
    }

    public function testValidateFailsWhenRequestResultsInANon200Response(): Generator
    {
        $this->httpClient
            ->method('request')
            ->willReturnCallback(function (Request $request) {
                $this->assertSame('https://pieterhordijk.com/foobar', (string) $request->getUri());

                $response = $this->createMock(Response::class);

                $response
                    ->method('getBody')
                    ->willReturn('foo')
                ;

                $response
                    ->method('getNumericalStatusCode')
                    ->willReturn(404)
                ;

                return new Success($response);
            })
        ;

        /** @var Result $result */
        $result = yield (new OkResponse($this->httpClient))->validate('https://pieterhordijk.com/foobar');

        $this->assertFalse($result->isValid());
        $this->assertSame('Network.Url.OkResponse', $result->getFirstError()->getMessage());
    }

    public function testValidateFailsWhenRequestResultsADnsException(): Generator
    {
        $this->httpClient
            ->method('request')
            ->willReturnCallback(function (Request $request): void {
                $this->assertSame('https://pieterhordijk.com/foobar', (string) $request->getUri());

                throw new DnsException();
            })
        ;

        /** @var Result $result */
        $result = yield (new OkResponse($this->httpClient))->validate('https://pieterhordijk.com/foobar');

        $this->assertFalse($result->isValid());
        $this->assertSame('Network.Url.OkResponse', $result->getFirstError()->getMessage());
    }

    public function testValidateReturnsTrueWhenClientReturnsOkResponse(): Generator
    {
        $this->httpClient
            ->method('request')
            ->willReturnCallback(function (Request $request) {
                $this->assertSame('https://pieterhordijk.com/contact', (string) $request->getUri());

                $response = $this->createMock(Response::class);

                $response
                    ->method('getBody')
                    ->willReturn('foo')
                ;

                $response
                    ->method('getNumericalStatusCode')
                    ->willReturn(200)
                ;

                return new Success($response);
            })
        ;

        /** @var Result $result */
        $result = yield (new OkResponse($this->httpClient))->validate('https://pieterhordijk.com/contact');

        $this->assertTrue($result->isValid());
        $this->assertNull($result->getFirstError());
    }
}
