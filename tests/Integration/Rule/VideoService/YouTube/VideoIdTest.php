<?php declare(strict_types=1);

namespace HarmonyIO\ValidationTest\Integration\Rule\VideoService\YouTube;

use Amp\Http\Client\HttpClientBuilder;
use Amp\PHPUnit\AsyncTestCase;
use Amp\Redis\Config;
use Amp\Redis\Redis as RedisClient;
use Amp\Redis\RemoteExecutor;
use Generator;
use HarmonyIO\Cache\Provider\Redis as RedisProvider;
use HarmonyIO\HttpClient\Client\HttpClient;
use HarmonyIO\Validation\Result\Result;
use HarmonyIO\Validation\Rule\VideoService\YouTube\VideoId;

class VideoIdTest extends AsyncTestCase
{
    /** @var HttpClient */
    private $httpClient;

    public function setUp(): void
    {
        parent::setUp();

        $client = HttpClientBuilder::buildDefault();
        $redis  = new RedisProvider(new RedisClient(new RemoteExecutor(Config::fromUri('tcp://localhost:6379'))));

        $this->httpClient = new HttpClient($client, $redis);
    }

    /**
     * @dataProvider provideNonExistingYouTubeIds
     */
    public function testValidateFailsOnNonExistingYouTubeId(string $id): Generator
    {
        /** @var Result $result */
        $result = yield (new VideoId($this->httpClient))->validate($id);

        $this->assertFalse($result->isValid());
        $this->assertSame('VideoService.YouTube.VideoId', $result->getFirstError()->getMessage());
    }

    /**
     * @dataProvider provideValidYouTubeIds
     */
    public function testValidateSucceedsOnValidYouTubeId(string $id): Generator
    {
        /** @var Result $result */
        $result = yield (new VideoId($this->httpClient))->validate($id);

        $this->assertTrue($result->isValid());
        $this->assertNull($result->getFirstError());
    }

    /**
     * @return array<array<string>>
     */
    public function provideNonExistingYouTubeIds(): array
    {
        return [
            ['bgUHF-N0XhM'],
            ['xxxxxxxxxxx'],
        ];
    }

    /**
     * @return array<array<string>>
     */
    public function provideValidYouTubeIds(): array
    {
        return [
            ['e64Ks2YoJuc'],
            ['jNQXAC9IVRw'],
            ['bgUHF_N0XhM'],
            ['TlqKFlU7YAs'],
            ['J3UyjlaBMcY'],
            ['-FIHqoTcZog'],
        ];
    }
}
