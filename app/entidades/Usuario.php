<?php

    class Usuario{
        
        private $idUsuario;
        private $nombre;
        private $contrasena;

        function __construct(){
            
        }

        function setNombre($nombre){
            
            $this->nombre = $nombre;
        }

        function setContrasena($contrasena){
            
            $this->contrasena = $contrasena;
        }

        function setIdUsuario($idUsuario){
            
            $this->idUsuario = $idUsuario;
        }

        function getNombre(){
            
            return $this->nombre;
        }

        function getContrasena(){
            
            return $this->contrasena;
        }

        function getIdUsuario(){
            
            return $this->idUsuario;
        }

        public static function obtenerUsuario($nombre){
            $objAccesoDatos = AccesoDatos::obtenerInstancia();
            $consulta = $objAccesoDatos->prepararConsulta("SELECT idUsuario, nombre, contrasena FROM usuario WHERE nombre=?");
            $consulta->execute(array($nombre));
            /*$consulta->setFetchMode(PDO::FETCH_CLASS, 'Usuario');*/
    
            /*return $consulta->fetch();*/
            return $consulta->fetch(PDO::FETCH_ASSOC);
            /*return $consulta->fetchAll(PDO::FETCH_CLASS, 'Usuario');*/
        }

        public static function obtenerNombresDeUsuarios(){
            $objAccesoDatos = AccesoDatos::obtenerInstancia();
            $consulta = $objAccesoDatos->prepararConsulta("SELECT nombre FROM usuario");
            $consulta->execute();
    
            return $consulta->fetchAll();
        }

        public function guardarUsuario(){
            $objAccesoDatos = AccesoDatos::obtenerInstancia();
            $consulta = $objAccesoDatos->prepararConsulta("INSERT INTO usuario(nombre, contrasena) VALUES (?,?)");
            $consulta->execute(array($this->nombre, $this->contrasena));
        }

        public function compararContrasena($contrasenaIngresada){
            
            return password_verify($contrasenaIngresada, $this->getContrasena());
        }
    }

?>