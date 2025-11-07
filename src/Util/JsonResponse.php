<?php


class JsonResponse {
    private $data;
    private $statusCode;

    public function __construct($data, int $statusCode = 200) {
        $this->data = $data;
        $this->statusCode = $statusCode;
    }

    public function send(): void {
        http_response_code($this->statusCode);
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($this->data);
        exit;
    }


}
