<?php declare(strict_types=1);

namespace HarmonyIO\ValidationTest\Unit\Rule\Isbn;

use Amp\Success;
use Generator;
use HarmonyIO\HttpClient\Client\Client;
use HarmonyIO\HttpClient\Message\Response;
use HarmonyIO\Validation\Result\Result;
use HarmonyIO\Validation\Rule\Isbn\Exists;
use HarmonyIO\ValidationTest\Unit\Rule\StringTestCase;
use PHPUnit\Framework\MockObject\MockObject;

class ExistsTest extends StringTestCase
{
    /** @var MockObject|Client */
    private $httpClient;

    /**
     * ExistsTest constructor.
     *
     * @param string|null $name
     * @param array<mixed> $data
     * @param string $dataName
     */
    public function __construct(?string $name = null, array $data = [], $dataName = '')
    {
        $this->httpClient = $this->createMock(Client::class);

        parent::__construct($name, $data, $dataName, Exists::class, $this->httpClient, '12345');
    }

    //phpcs:ignore SlevomatCodingStandard.TypeHints.TypeHintDeclaration.MissingReturnTypeHint
    public function setUp(): void
    {
        $this->httpClient = $this->createMock(Client::class);

        parent::setUp();
    }

    public function testValidateFailsWhenPassingInAnInvalidIsbn10(): Generator
    {
        /** @var Result $result */
        $result = yield (new Exists($this->httpClient, '12345'))->validate('0345391803');

        $this->assertFalse($result->isValid());
        $this->assertSame('Isbn.Isbn', $result->getFirstError()->getMessage());
    }

    public function testValidateFailsWhenPassingInAnInvalidIsbn13(): Generator
    {
        /** @var Result $result */
        $result = yield (new Exists($this->httpClient, '12345'))->validate('9788970137507');

        $this->assertFalse($result->isValid());
        $this->assertSame('Isbn.Isbn', $result->getFirstError()->getMessage());
    }

    public function testValidateFailsWhenServiceReturnsANon200Response(): Generator
    {
        $response = $this->createMock(Response::class);

        $response
            ->method('getBody')
            ->willReturn(json_encode(['foo' => 'bar']))
        ;

        $response
            ->method('getNumericalStatusCode')
            ->willReturn(500)
        ;

        $this->httpClient
            ->method('request')
            ->willReturn(new Success($response))
        ;

        /** @var Result $result */
        $result = yield (new Exists($this->httpClient, '12345'))->validate('9788970137506');

        $this->assertFalse($result->isValid());
        $this->assertSame('Isbn.Exists', $result->getFirstError()->getMessage());
    }

    public function testValidateFailsWhenServiceReturnsInvalidJson(): Generator
    {
        $response = $this->createMock(Response::class);

        $response
            ->method('getBody')
            ->willReturn('foobar')
        ;

        $response
            ->method('getNumericalStatusCode')
            ->willReturn(200)
        ;

        $this->httpClient
            ->method('request')
            ->willReturn(new Success($response))
        ;

        /** @var Result $result */
        $result = yield (new Exists($this->httpClient, '12345'))->validate('9788970137506');

        $this->assertFalse($result->isValid());
        $this->assertSame('Isbn.Exists', $result->getFirstError()->getMessage());
    }

    public function testValidateFailsWhenIsbnDoesNotExist()
    {
        $response = $this->createMock(Response::class);

        $response
            ->method('getBody')
            ->willReturn(json_encode(['totalItems' => 0]))
        ;

        $response
            ->method('getNumericalStatusCode')
            ->willReturn(200)
        ;

        $this->httpClient
            ->method('request')
            ->willReturn(new Success($response))
        ;

        /** @var Result $result */
        $result = yield (new Exists($this->httpClient, '12345'))->validate('9788970137506');

        $this->assertFalse($result->isValid());
        $this->assertSame('Isbn.Exists', $result->getFirstError()->getMessage());
    }

    public function testValidateSucceedsWhenIsbnDoesExist(): Generator
    {
        $response = $this->createMock(Response::class);

        $response
            ->method('getBody')
            ->willReturn(json_encode(['totalItems' => 1]))
        ;

        $response
            ->method('getNumericalStatusCode')
            ->willReturn(200)
        ;

        $this->httpClient
            ->method('request')
            ->willReturn(new Success($response))
        ;

        /** @var Result $result */
        $result = yield (new Exists($this->httpClient, '12345'))->validate('9788970137506');

        $this->assertTrue($result->isValid());
        $this->assertNull($result->getFirstError());
    }

    public function testValidateSucceedsWhenMultipleBooksWithIsbnExist(): Generator
    {
        $response = $this->createMock(Response::class);

        $response
            ->method('getBody')
            ->willReturn(json_encode(['totalItems' => 2]))
        ;

        $response
            ->method('getNumericalStatusCode')
            ->willReturn(200)
        ;

        $this->httpClient
            ->method('request')
            ->willReturn(new Success($response))
        ;

        /** @var Result $result */
        $result = yield (new Exists($this->httpClient, '12345'))->validate('9788970137506');

        $this->assertTrue($result->isValid());
        $this->assertNull($result->getFirstError());
    }
}
