<?php

require dirname(__DIR__) . '/vendor/autoload.php';

class ElasticsearchTest extends PHPUnit\Framework\TestCase
{
    public function test_neologdA()
    {
        $client = new \GuzzleHttp\Client([
            'base_uri' => 'http://localhost:9200'
        ]);
        $response = $client->request('GET', '/neologd/_analyze', [
            'json' => ['text' => 'こんにちは世界'],
        ]);

        self::assertEquals(200, $response->getStatusCode());
        $expected = '{"tokens":[{"token":"こんにちは","start_offset":0,"end_offset":5,"type":"word","position":0},{"token":"世界","start_offset":5,"end_offset":7,"type":"word","position":1}]}';
        self::assertJsonStringEqualsJsonString($expected, $response->getBody()->getContents());
    }

    public function test_neologdB()
    {
        $client = new \GuzzleHttp\Client([
            'base_uri' => 'http://localhost:9200'
        ]);
        $response = $client->request('GET', '/neologd/_analyze', [
            'json' => ['text' => 'きゃりーぱみゅぱみゅ'],
        ]);

        self::assertEquals(200, $response->getStatusCode());
        $expected = '{"tokens":[{"token":"きゃりーぱみゅぱみゅ","start_offset":0,"end_offset":10,"type":"word","position":0}]}';
        self::assertJsonStringEqualsJsonString($expected, $response->getBody()->getContents());
    }

    public function test_neologdC()
    {
        $client = new \GuzzleHttp\Client([
            'base_uri' => 'http://localhost:9200'
        ]);
        $response = $client->request('GET', '/neologd/_analyze', [
            'json' => ['text' => '安倍晋三首相が１５日、来年１０月の消費増税方針を示したのは、増税分を財源とする「全世代型社会保障」を昨年の衆院選と今年９月の自民党総裁選で自ら公約した以上、増税の準備を促す「再表明」が避けられないと判断したためだ。'],
        ]);

        self::assertEquals(200, $response->getStatusCode());
        $expected = '{"tokens":[{"token":"安倍晋三","start_offset":0,"end_offset":4,"type":"word","position":0},{"token":"安倍晋三首相","start_offset":0,"end_offset":6,"type":"word","position":0,"positionLength":2},{"token":"首相","start_offset":4,"end_offset":6,"type":"word","position":1},{"token":"が","start_offset":6,"end_offset":7,"type":"word","position":2},{"token":"１","start_offset":7,"end_offset":8,"type":"word","position":3},{"token":"５","start_offset":8,"end_offset":9,"type":"word","position":4},{"token":"日","start_offset":9,"end_offset":10,"type":"word","position":5},{"token":"来年","start_offset":11,"end_offset":13,"type":"word","position":6},{"token":"１０月","start_offset":13,"end_offset":16,"type":"word","position":7},{"token":"の","start_offset":16,"end_offset":17,"type":"word","position":8},{"token":"消費","start_offset":17,"end_offset":19,"type":"word","position":9},{"token":"消費増税","start_offset":17,"end_offset":21,"type":"word","position":9,"positionLength":2},{"token":"増税","start_offset":19,"end_offset":21,"type":"word","position":10},{"token":"方針","start_offset":21,"end_offset":23,"type":"word","position":11},{"token":"を","start_offset":23,"end_offset":24,"type":"word","position":12},{"token":"示し","start_offset":24,"end_offset":26,"type":"word","position":13},{"token":"た","start_offset":26,"end_offset":27,"type":"word","position":14},{"token":"の","start_offset":27,"end_offset":28,"type":"word","position":15},{"token":"は","start_offset":28,"end_offset":29,"type":"word","position":16},{"token":"増税","start_offset":30,"end_offset":32,"type":"word","position":17},{"token":"分","start_offset":32,"end_offset":33,"type":"word","position":18},{"token":"を","start_offset":33,"end_offset":34,"type":"word","position":19},{"token":"財源","start_offset":34,"end_offset":36,"type":"word","position":20},{"token":"と","start_offset":36,"end_offset":37,"type":"word","position":21},{"token":"する","start_offset":37,"end_offset":39,"type":"word","position":22},{"token":"全","start_offset":40,"end_offset":41,"type":"word","position":23},{"token":"世代","start_offset":41,"end_offset":43,"type":"word","position":24},{"token":"型","start_offset":43,"end_offset":44,"type":"word","position":25},{"token":"社会","start_offset":44,"end_offset":46,"type":"word","position":26},{"token":"社会保障","start_offset":44,"end_offset":48,"type":"word","position":26,"positionLength":2},{"token":"保障","start_offset":46,"end_offset":48,"type":"word","position":27},{"token":"を","start_offset":49,"end_offset":50,"type":"word","position":28},{"token":"昨年","start_offset":50,"end_offset":52,"type":"word","position":29},{"token":"の","start_offset":52,"end_offset":53,"type":"word","position":30},{"token":"衆院","start_offset":53,"end_offset":55,"type":"word","position":31},{"token":"衆院選","start_offset":53,"end_offset":56,"type":"word","position":31,"positionLength":2},{"token":"選","start_offset":55,"end_offset":56,"type":"word","position":32},{"token":"と","start_offset":56,"end_offset":57,"type":"word","position":33},{"token":"今年","start_offset":57,"end_offset":59,"type":"word","position":34},{"token":"９月","start_offset":59,"end_offset":61,"type":"word","position":35},{"token":"の","start_offset":61,"end_offset":62,"type":"word","position":36},{"token":"自民党","start_offset":62,"end_offset":65,"type":"word","position":37},{"token":"自民党総裁","start_offset":62,"end_offset":67,"type":"word","position":37,"positionLength":2},{"token":"総裁","start_offset":65,"end_offset":67,"type":"word","position":38},{"token":"選","start_offset":67,"end_offset":68,"type":"word","position":39},{"token":"で","start_offset":68,"end_offset":69,"type":"word","position":40},{"token":"自ら","start_offset":69,"end_offset":71,"type":"word","position":41},{"token":"公約","start_offset":71,"end_offset":73,"type":"word","position":42},{"token":"し","start_offset":73,"end_offset":74,"type":"word","position":43},{"token":"た","start_offset":74,"end_offset":75,"type":"word","position":44},{"token":"以上","start_offset":75,"end_offset":77,"type":"word","position":45},{"token":"増税","start_offset":78,"end_offset":80,"type":"word","position":46},{"token":"の","start_offset":80,"end_offset":81,"type":"word","position":47},{"token":"準備","start_offset":81,"end_offset":83,"type":"word","position":48},{"token":"を","start_offset":83,"end_offset":84,"type":"word","position":49},{"token":"促す","start_offset":84,"end_offset":86,"type":"word","position":50},{"token":"再","start_offset":87,"end_offset":88,"type":"word","position":51},{"token":"表明","start_offset":88,"end_offset":90,"type":"word","position":52},{"token":"が","start_offset":91,"end_offset":92,"type":"word","position":53},{"token":"避け","start_offset":92,"end_offset":94,"type":"word","position":54},{"token":"られ","start_offset":94,"end_offset":96,"type":"word","position":55},{"token":"ない","start_offset":96,"end_offset":98,"type":"word","position":56},{"token":"と","start_offset":98,"end_offset":99,"type":"word","position":57},{"token":"判断","start_offset":99,"end_offset":101,"type":"word","position":58},{"token":"し","start_offset":101,"end_offset":102,"type":"word","position":59},{"token":"た","start_offset":102,"end_offset":103,"type":"word","position":60},{"token":"ため","start_offset":103,"end_offset":105,"type":"word","position":61},{"token":"だ","start_offset":105,"end_offset":106,"type":"word","position":62}]}';
        self::assertJsonStringEqualsJsonString($expected, $response->getBody()->getContents());
    }

    public function test_neologdD()
    {
        $client = new \GuzzleHttp\Client([
            'base_uri' => 'http://localhost:9200'
        ]);
        $response = $client->request('GET', '/neologd/_analyze', [
            'json' => ['text' => '東京都知事選挙'],
        ]);

        self::assertEquals(200, $response->getStatusCode());
        $expected = '{"tokens":[{"token":"東京都","start_offset":0,"end_offset":3,"type":"word","position":0},{"token":"東京都知事選挙","start_offset":0,"end_offset":7,"type":"word","position":0,"positionLength":3},{"token":"知事","start_offset":3,"end_offset":5,"type":"word","position":1},{"token":"選挙","start_offset":5,"end_offset":7,"type":"word","position":2}]}';
        self::assertJsonStringEqualsJsonString($expected, $response->getBody()->getContents());
    }
}
