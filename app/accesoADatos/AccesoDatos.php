<?php

    class AccesoDatos {

        private static $objAccesoDatos;
        private $objetoPDO;

        private function __construct(){
            try {
                $this->objetoPDO = new PDO('mysql:host=remotemysql.com:3306;dbname='.getenv("Database").';charset=utf8', getenv("Usuario"), getenv("Pass"), array(PDO::ATTR_EMULATE_PREPARES => false, PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
                //$this->objetoPDO = new PDO('mysql:host=bvxlep46koepmkjlsugm-mysql.services.clever-cloud.com:3306;dbname=bvxlep46koepmkjlsugm;charset=utf8', 'uol4ujv0riizo0jj', 'yNuZgoZIpupIeTPPBh8b', array(PDO::ATTR_EMULATE_PREPARES => false, PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
                $this->objetoPDO->exec("SET CHARACTER SET utf8");
            } catch (PDOException $e) {
                print "Error: " . $e->getMessage();
                die();
            }
        }

        public static function obtenerInstancia(){
            if (!isset(self::$objAccesoDatos)) {
                self::$objAccesoDatos = new AccesoDatos();
            }
            return self::$objAccesoDatos;
        }

        public function prepararConsulta($sql){
            return $this->objetoPDO->prepare($sql);
        }

        public function obtenerUltimoId(){
            return $this->objetoPDO->lastInsertId();
        }

        public function __clone(){
            trigger_error('ERROR: La clonación de este objeto no está permitida', E_USER_ERROR);
        }
    }

?>