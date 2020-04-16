<?php declare(strict_types=1);

namespace HarmonyIO\ValidationTest\Unit\Rule\VideoService\YouTube;

use Amp\Success;
use Generator;
use HarmonyIO\HttpClient\Client\Client;
use HarmonyIO\HttpClient\Message\Response;
use HarmonyIO\Validation\Result\Result;
use HarmonyIO\Validation\Rule\VideoService\YouTube\VideoUrl;
use HarmonyIO\ValidationTest\Unit\Rule\StringTestCase;
use PHPUnit\Framework\MockObject\MockObject;

class VideoUrlTest extends StringTestCase
{
    /** @var MockObject|Client */
    private $httpClient;

    /**
     * VideoUrlTest constructor.
     *
     * @param string|null $name
     * @param array<mixed> $data
     * @param string $dataName
     */
    public function __construct(?string $name = null, array $data = [], $dataName = '')
    {
        $this->httpClient = $this->createMock(Client::class);

        parent::__construct($name, $data, $dataName, VideoUrl::class, $this->httpClient);
    }

    public function setUp(): void
    {
        $this->httpClient = $this->createMock(Client::class);

        parent::setUp();
    }

    public function testValidateFailsOnUnrecognizedUrlProtocol(): Generator
    {
        $this->httpClient
            ->expects($this->never())
            ->method('request')
        ;

        /** @var Result $result */
        $result = yield (new VideoUrl($this->httpClient))->validate('ftp://youtube.com/watch?v=jNQXAC9IVRw');

        $this->assertFalse($result->isValid());
        $this->assertSame('VideoService.YouTube.VideoUrl', $result->getFirstError()->getMessage());
    }

    public function testValidateFailsOnUnrecognizedDomain(): Generator
    {
        $this->httpClient
            ->expects($this->never())
            ->method('request')
        ;

        /** @var Result $result */
        $result = yield (new VideoUrl($this->httpClient))->validate('https://notyoutube.com/watch?v=jNQXAC9IVRw');

        $this->assertFalse($result->isValid());
        $this->assertSame('VideoService.YouTube.VideoUrl', $result->getFirstError()->getMessage());
    }

    public function testValidateFailsOnMissingPath(): Generator
    {
        $this->httpClient
            ->expects($this->never())
            ->method('request')
        ;

        /** @var Result $result */
        $result = yield (new VideoUrl($this->httpClient))->validate('https://youtube.com/');

        $this->assertFalse($result->isValid());
        $this->assertSame('VideoService.YouTube.VideoUrl', $result->getFirstError()->getMessage());
    }

    public function testValidateFailsWhenWatchIsInPathButMissingAQueryString(): Generator
    {
        $this->httpClient
            ->expects($this->never())
            ->method('request')
        ;

        /** @var Result $result */
        $result = yield (new VideoUrl($this->httpClient))->validate('https://youtube.com/watch');

        $this->assertFalse($result->isValid());
        $this->assertSame('VideoService.YouTube.VideoUrl', $result->getFirstError()->getMessage());
    }

    public function testValidateFailsWhenWatchIsInPathButMissingTheVQueryStringParameter(): Generator
    {
        $this->httpClient
            ->expects($this->never())
            ->method('request')
        ;

        /** @var Result $result */
        $result = yield (new VideoUrl($this->httpClient))->validate('https://youtube.com/watch?foo=bar');

        $this->assertFalse($result->isValid());
        $this->assertSame('VideoService.YouTube.VideoUrl', $result->getFirstError()->getMessage());
    }

    /**
     * @dataProvider provideInvalidYouTubeUrls
     */
    public function testValidateFailsForInvalidYouTubeUrl(string $url): Generator
    {
        $this->httpClient
            ->expects($this->never())
            ->method('request')
        ;

        /** @var Result $result */
        $result = yield (new VideoUrl($this->httpClient))->validate($url);

        $this->assertFalse($result->isValid());
        $this->assertSame('VideoService.YouTube.VideoUrl', $result->getFirstError()->getMessage());
    }

    public function testValidateSucceedsWhenWatchIsNotInPath(): Generator
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
            ->expects($this->once())
            ->method('request')
            ->willReturn(new Success($response))
        ;

        /** @var Result $result */
        $result = yield (new VideoUrl($this->httpClient))->validate('https://youtube.com/foobar');

        $this->assertTrue($result->isValid());
        $this->assertNull($result->getFirstError());
    }

    public function testValidateSucceedsWhenUrlContainsBothTheWatchPathAndTheVQueryStringParameter(): Generator
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
            ->expects($this->once())
            ->method('request')
            ->willReturn(new Success($response))
        ;

        /** @var Result $result */
        $result = yield (new VideoUrl($this->httpClient))->validate('https://youtube.com/watch?v=bar');

        $this->assertTrue($result->isValid());
        $this->assertNull($result->getFirstError());
    }

    /**
     * @dataProvider provideValidYouTubeUrls
     */
    public function testValidateSucceedsForValidYouTubeUrl(string $url): Generator
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
            ->expects($this->once())
            ->method('request')
            ->willReturn(new Success($response))
        ;

        /** @var Result $result */
        $result = yield (new VideoUrl($this->httpClient))->validate($url);

        $this->assertTrue($result->isValid());
        $this->assertNull($result->getFirstError());
    }

    /**
     * @return array<array<string>>
     */
    public function provideInvalidYouTubeUrls(): array
    {
        return [
            ['http://youtube.be.com/watch?v=jNQXAC9IVRw'],
            ['https://youtubecom/watch?v=jNQXAC9IVRw'],
            ['https://youtubebe/watch?v=jNQXAC9IVRw'],
            ['https://example.com/watch?v=jNQXAC9IVRw'],
            ['http://youtube.com/watch?iv=jNQXAC9IVRw'],
        ];
    }

    /**
     * @return array<array<string>>
     */
    public function provideValidYouTubeUrls(): array
    {
        return [
            ['http://youtube.com/watch?v=jNQXAC9IVRw'],
            ['http://www.youtube.com/watch?v=jNQXAC9IVRw&feature=related'],
            ['https://youtube.com/jNQXAC9IVRw'],
            ['http://youtu.be/jNQXAC9IVRw'],
            ['youtube.com/jNQXAC9IVRw'],
            ['youtube.com/jNQXAC9IVRw'],
            ['http://www.youtube.com/embed/watch?feature=player_embedded&v=jNQXAC9IVRw'],
            ['http://www.youtube.com/watch?v=jNQXAC9IVRw'],
            ['http://youtu.be/jNQXAC9IVRw'],
        ];
    }
}
