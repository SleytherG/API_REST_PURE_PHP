<?php

require_once __DIR__ . '/HttpStatus.php';
class HttpResponses {
    public static HttpStatus $OK;
    public static HttpStatus $CREATED;
    public static HttpStatus $ACCEPTED;
    public static HttpStatus $NO_CONTENT;

    public static HttpStatus $BAD_REQUEST;
    public static HttpStatus $UNAUTHORIZED;
    public static HttpStatus $FORBIDDEN;
    public static HttpStatus $NOT_FOUND;
    public static HttpStatus $METHOD_NOT_ALLOWED;
    public static HttpStatus $CONFLICT;
    public static HttpStatus $UNPROCESSABLE_ENTITY;

    public static HttpStatus $INTERNAL_SERVER_ERROR;
    public static HttpStatus $NOT_IMPLEMENTED;
    public static HttpStatus $SERVICE_UNAVAILABLE;

    public static function init(): void {
        self::$OK = new HttpStatus(200, 'Success');
        self::$CREATED = new HttpStatus(201, 'Resource created successfully');
        self::$ACCEPTED = new HttpStatus(202, 'Request accepted');
        self::$NO_CONTENT = new HttpStatus(204, 'No content');

        self::$BAD_REQUEST = new HttpStatus(400, 'Bad request');
        self::$UNAUTHORIZED = new HttpStatus(401, 'Unauthorized');
        self::$FORBIDDEN = new HttpStatus(403, 'Forbidden');
        self::$NOT_FOUND = new HttpStatus(404, 'Not found');
        self::$METHOD_NOT_ALLOWED = new HttpStatus(405, 'Method not allowed');
        self::$CONFLICT = new HttpStatus(409, 'Conflict');
        self::$UNPROCESSABLE_ENTITY = new HttpStatus(422, 'Unprocessable entity');

        self::$INTERNAL_SERVER_ERROR = new HttpStatus(500, 'Internal server error');
        self::$NOT_IMPLEMENTED = new HttpStatus(501, 'Not implemented');
        self::$SERVICE_UNAVAILABLE = new HttpStatus(503, 'Service unavailable');
    }
}