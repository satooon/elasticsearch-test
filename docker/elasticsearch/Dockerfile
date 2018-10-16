FROM docker.elastic.co/elasticsearch/elasticsearch:6.4.2

RUN elasticsearch-plugin install analysis-kuromoji
RUN elasticsearch-plugin install --batch org.codelibs:elasticsearch-analysis-kuromoji-neologd:6.4.0
