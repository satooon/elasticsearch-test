<?php

require dirname(__DIR__) . '/vendor/autoload.php';

class PollyTest extends PHPUnit\Framework\TestCase
{
    public static function setUpBeforeClass()
    {
        parent::setUpBeforeClass();

        (new Dotenv\Dotenv(dirname(__DIR__)))->load();
    }

    public function test_pollyA()
    {
        $credentials = new Aws\Credentials\Credentials(
            getenv('aws_access_key'),
            getenv('aws_secret_access_key')
        );
        $client = new Aws\Polly\PollyClient([
            'region' => 'us-east-1',
            'version' => 'latest',
            'credentials' => $credentials,
        ]);
        $result = $client->synthesizeSpeech([
            'LanguageCode' => 'en-US',
            'OutputFormat' => 'mp3',
            'Text' => 'Hello World!',
            'TextType' => 'text',
            'VoiceId' => 'Salli',
        ]);

        /** @var \GuzzleHttp\Psr7\Stream $stream */
        $stream = $result->get('AudioStream');
        self::assertTrue($stream instanceof \GuzzleHttp\Psr7\Stream);
        self::assertNotFalse(file_put_contents(sprintf("%s/test_pollyA.mp3", __DIR__), $stream));
    }

    public function test_pollyB()
    {
        $client = new \GuzzleHttp\Client([
            'base_uri' => 'http://localhost:9200'
        ]);
        $response = $client->request('GET', '/neologd/_analyze', [
            'json' => ['text' => 'こんにちは世界'],
        ]);
        self::assertEquals(200, $response->getStatusCode());
        $json = json_decode($response->getBody()->getContents());

        $credentials = new Aws\Credentials\Credentials(
            getenv('aws_access_key'),
            getenv('aws_secret_access_key')
        );
        $translateClient = new Aws\Translate\TranslateClient([
            'region' => 'us-east-1',
            'version' => 'latest',
            'credentials' => $credentials,
        ]);
        $pollyClient = new Aws\Polly\PollyClient([
            'region' => 'us-east-1',
            'version' => 'latest',
            'credentials' => $credentials,
        ]);

        foreach ($json->tokens as $token) {
            $text = $translateClient->translateText([
                'SourceLanguageCode' => 'ja',
                'TargetLanguageCode' => 'en',
                'Text' => $token->token,
            ]);
            self::assertNotEmpty($text->get('TranslatedText'));

            $speech = $pollyClient->synthesizeSpeech([
                'LanguageCode' => 'en-US',
                'OutputFormat' => 'mp3',
                'Text' => $text->get('TranslatedText'),
                'TextType' => 'text',
                'VoiceId' => 'Salli',
            ]);

            /** @var \GuzzleHttp\Psr7\Stream $stream */
            $stream = $speech->get('AudioStream');
            self::assertTrue($stream instanceof \GuzzleHttp\Psr7\Stream);
            self::assertNotFalse(file_put_contents(sprintf("%s/test_pollyB_%s.mp3", __DIR__, $text->get('TranslatedText')), $stream));
        }
    }
}