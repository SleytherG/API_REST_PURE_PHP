<?php

class DatabasePDO {

    private static ?PDO $connection = null;

    public static function getConnection(
        string $driver = 'pgsql',
        array $options = [],
    ): PDO {
        if (self::$connection === null) {
            $host = getenv('DB_HOST') ?: 'localhost';
            $port = getenv('DB_PORT') ?: '5432';
            $dbname = getenv('DB_NAME') ?: 'apirest';
            $user = getenv('DB_USER') ?: 'postgres';
            $password = getenv('DB_PASSWORD') ?: 'postgres';
            switch ($driver) {
                case 'mysql':
                case 'mariadb':
                    $dsn = "mysql:host=$host;port=$port;dbname=$dbname;charset=utf8mb4";
                    break;
                case 'pgsql':
                    $dsn = "pgsql:host=$host;port=$port;dbname=$dbname";
                    break;
                case 'sqlite':
                    $dsn = "sqlite:$dbname";
                    break;
                case 'sqlsrv':
                    $dsn = "sqlsrv:Server=$host,$port;Database=$dbname";
                    break;
                case 'oci':
                    $dsn = "oci:dbname=//$host:$port/$dbname";
                    break;
                default:
                    throw new InvalidArgumentException("Driver no soportado: $driver");
            }
            self::$connection = new PDO($dsn, $user, $password, $options);
            self::$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }
        return self::$connection;
    }
}

