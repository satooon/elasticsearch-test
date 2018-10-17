参考

> * [neologdでkuromojiを新語に対応させる - Carpe Diem](https://christina04.hatenablog.com/entry/2016/05/18/193000)


## Setup

```
$ docker-compose up --build -d

$ curl -H 'Content-Type: application/json' -XPUT 'http://localhost:9200/neologd/?pretty' -d'
{
    "settings": {
        "index":{
            "analysis":{
                "analyzer" : {
                    "default" : {
                        "tokenizer" : "kuromoji_neologd_tokenizer"
                    }
                }
            }
        }
    }
}'

$ cd php
$ ./composer.phar install
$ cp .env.sample .env # and edit
```

## Test

```
$ cd php
$ ./vendor/bin/phpunit test
```
