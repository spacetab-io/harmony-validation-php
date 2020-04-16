<?php declare(strict_types=1);

namespace HarmonyIO\ValidationTest\Unit\Rule\VideoService\YouTube;

use Amp\Success;
use Generator;
use HarmonyIO\HttpClient\Client\Client;
use HarmonyIO\HttpClient\Message\Response;
use HarmonyIO\Validation\Result\Result;
use HarmonyIO\Validation\Rule\VideoService\YouTube\VideoId;
use HarmonyIO\ValidationTest\Unit\Rule\StringTestCase;
use PHPUnit\Framework\MockObject\MockObject;

class VideoIdTest extends StringTestCase
{
    /** @var MockObject|Client */
    private $httpClient;

    /**
     * VideoIdTest constructor.
     *
     * @param string|null $name
     * @param array<mixed> $data
     * @param string $dataName
     */
    public function __construct(?string $name = null, array $data = [], $dataName = '')
    {
        $this->httpClient = $this->createMock(Client::class);

        parent::__construct($name, $data, $dataName, VideoId::class, $this->httpClient);
    }

    public function setUp(): void
    {
        $this->httpClient = $this->createMock(Client::class);

        parent::setUp();
    }

    public function testValidateFailsOnNon200Response(): Generator
    {
        $response = $this->createMock(Response::class);

        $response
            ->method('getNumericalStatusCode')
            ->willReturn(400)
        ;

        $this->httpClient
            ->method('request')
            ->willReturn(new Success($response))
        ;

        /** @var Result $result */
        $result = yield (new VideoId($this->httpClient))->validate('youtubeId');

        $this->assertFalse($result->isValid());
        $this->assertSame('VideoService.YouTube.VideoId', $result->getFirstError()->getMessage());
    }

    public function testValidateFailsForNonJsonResponse(): Generator
    {
        $response = $this->createMock(Response::class);

        $response
            ->method('getBody')
            ->willReturn('notJson')
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
        $result = yield (new VideoId($this->httpClient))->validate('youtubeId');

        $this->assertFalse($result->isValid());
        $this->assertSame('VideoService.YouTube.VideoId', $result->getFirstError()->getMessage());
    }

    public function testValidateFailsWhenJsonResponseDoesNotContainTypeKey(): Generator
    {
        $response = $this->createMock(Response::class);

        $response
            ->method('getBody')
            ->willReturn(json_encode(['notType' => 'video']))
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
        $result = yield (new VideoId($this->httpClient))->validate('youtubeId');

        $this->assertFalse($result->isValid());
        $this->assertSame('VideoService.YouTube.VideoId', $result->getFirstError()->getMessage());
    }

    public function testValidateFailsWhenTypeIsNotVideo(): Generator
    {
        $response = $this->createMock(Response::class);

        $response
            ->method('getBody')
            ->willReturn(json_encode(['type' => 'notVideo']))
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
        $result = yield (new VideoId($this->httpClient))->validate('youtubeId');

        $this->assertFalse($result->isValid());
        $this->assertSame('VideoService.YouTube.VideoId', $result->getFirstError()->getMessage());
    }

    public function testValidateSucceedsForValidId(): Generator
    {
        $response = $this->createMock(Response::class);

        $response
            ->method('getBody')
            ->willReturn(json_encode(['type' => 'video']))
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
        $result = yield (new VideoId($this->httpClient))->validate('youtubeId');

        $this->assertTrue($result->isValid());
        $this->assertNull($result->getFirstError());
    }
}
