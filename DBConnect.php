<?php
    class DBConnect {
       
        const DB_NAME = 'inscription_form';
        const MYSQL_SERVER = 'mysql:host=localhost;dbname=' . self::DB_NAME . ';charset=utf8';
        const PGSQL_SERVER = 'pgsql:host=localhost;dbname=' . self::DB_NAME . ';charset=utf8';
        const SQL_USER = 'root';
        const SQL_PASSWORD = '';

       
        public static function getMySqlConnection() {
           
            $dataBase = new PDO(self::MYSQL_SERVER, self::SQL_USER, self::SQL_PASSWORD);

            $dataBase->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            return $dataBase;
        }
        
        /*si PostgreSQL*/

        public static function getPgSqlConnection() {
            $dataBase = new PDO(self::PGSQL_SERVER, self::SQL_USER, self::SQL_PASSWORD);
            $dataBase->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            return $dataBase;
        }
    };
