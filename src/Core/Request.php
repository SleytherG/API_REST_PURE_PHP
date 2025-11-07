<?php

class Request {
    private array $body;
    public function __construct() {
        $this->body = getJsonInput();
    }

    public function getBody(): array {
        return $this->body;
    }
}