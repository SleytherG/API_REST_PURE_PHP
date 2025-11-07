<?php


require_once __DIR__ . '/../Util/Helpers.php';
abstract class Controller {
    protected function json($data, int $status = 200): void {
        sendJson($data, $status);
    }

    protected function input(): array {
        return getJsonInput();
    }


}
