<?php

namespace Core\Http;

class Request
{
    public protected(set) string $httpMethod;
    public protected(set) string $uri;
    public protected(set) string $path;
    public protected(set) array $query = [];
    public protected(set) array $headers;
    public protected(set) array $params = [];
    public protected(set) array $body;

    public function __construct()
    {
        $this->httpMethod = $_SERVER['REQUEST_METHOD'];
        $this->uri = $_SERVER['REQUEST_URI'];
        $this->path = trim(parse_url($this->uri, PHP_URL_PATH));
        parse_str(parse_url($this->uri, PHP_URL_QUERY) ?? '', $this->query);
        $this->headers = getallheaders();
    }

    public function setParams(array $params): void
    {
        $this->params = $params;
    }

    public function getBody()
    {
        $test = $_POST;

    }

}
