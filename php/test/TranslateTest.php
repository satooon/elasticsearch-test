<?php

require dirname(__DIR__) . '/vendor/autoload.php';

class TranslateTest extends PHPUnit\Framework\TestCase
{
    public static function setUpBeforeClass()
    {
        parent::setUpBeforeClass();

        (new Dotenv\Dotenv(dirname(__DIR__)))->load();
    }

    public function test_translateTextA()
    {
        $credentials = new Aws\Credentials\Credentials(
            getenv('aws_access_key'),
            getenv('aws_secret_access_key')
        );
        $client = new Aws\Translate\TranslateClient([
            'region' => 'us-east-1',
            'version' => 'latest',
            'credentials' => $credentials,
        ]);

        $result = $client->translateText([
            'SourceLanguageCode' => 'en',
            'TargetLanguageCode' => 'ja',
            'Text' => 'old woman',
        ]);
        self::assertEquals('おばあさん', $result->get('TranslatedText'));
    }

    public function test_translateTextB()
    {
        $credentials = new Aws\Credentials\Credentials(
            getenv('aws_access_key'),
            getenv('aws_secret_access_key')
        );
        $client = new Aws\Translate\TranslateClient([
            'region' => 'us-east-1',
            'version' => 'latest',
            'credentials' => $credentials,
        ]);

        $result = $client->translateText([
            'SourceLanguageCode' => 'ja',
            'TargetLanguageCode' => 'en',
            'Text' => 'おばあさん',
        ]);
        self::assertEquals('Granny', $result->get('TranslatedText'));
    }

    public function test_translateTextC()
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
        $client = new Aws\Translate\TranslateClient([
            'region' => 'us-east-1',
            'version' => 'latest',
            'credentials' => $credentials,
        ]);

        foreach ($json->tokens as $token) {
            $result = $client->translateText([
                'SourceLanguageCode' => 'ja',
                'TargetLanguageCode' => 'en',
                'Text' => $token->token,
            ]);
            self::assertNotEmpty($result->get('TranslatedText'));
            echo sprintf("\n%s => %s", $token->token, $result->get('TranslatedText'));
        }
    }
}
