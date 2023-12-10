<?php

namespace Request;

class Request
{
    protected string $method;
    protected array $headers;
    protected array $body;

    public function __construct(string $method, array $body = [], array $headers= [])
    {
        $this->method = $method;
        $this->body = $body;
        $this->headers = $headers;
    }

    public function getMethod(): string
    {
        return $this->method;
    }

    public function getHeaders(): array
    {
        return $this->headers;
    }

    public function getBody(): array
    {
        return $this->body;
    }
}