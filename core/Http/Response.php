<?php

namespace Core\Http;

class Response
{
    public protected(set) string $responseType;
    public function __construct()
    {
    }

    public function setResponseType(string $responseType): void
    {
        $this->responseType = $responseType;
    }

    public function view( string $viewName, ?array $params, ?string $viewFolder = __DIR__ . '/../../src/Pages'): void
    {
        extract($params);
        include $viewFolder . $viewName;
    }

}