<?php

    class Usuario{
        
        public $nombre;
        public $contrasena;

        function __construct(){
            
        }

        function setNombre($nombre){
            
            $this->nombre = $nombre;
        }

        function setContrasena($contrasena){
            
            $this->contrasena = $contrasena;
        }

        function getNombre(){
            
            return $this->nombre;
        }

        function getContrasena(){
            
            return $this->contrasena;
        }

        public static function obtenerUsuario($nombre){
            $objAccesoDatos = AccesoDatos::obtenerInstancia();
            $consulta = $objAccesoDatos->prepararConsulta("SELECT nombre, contrasena FROM usuario WHERE nombre=?");
            $consulta->execute(array($nombre));
            //$consulta->setFetchMode(PDO::FETCH_CLASS, 'Usuario');
    
            return $consulta->fetch();
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