<?php

class DatabasePDO {

    private static ?PDO $connection = null;

    public static function getConnection(
        ?array $config = null,
        string $driver = 'pgsql',
        array $options = [],
    ): PDO {
        if (self::$connection === null) {
            if ($config === null) {
                $config = require __DIR__ . '/../Config/config.php';
                $config = $config['db'];
            }
            $host = $config['host'] ?? 'localhost';
            $port = $config['port'] ?? '';
            $dbname = $config['dbname'] ?? '';
            $user = $config['user'] ?? '';
            $password = $config['password'] ?? '';

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

