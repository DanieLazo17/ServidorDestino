<?php

    class Usuario{
        
        public $nombre;
        public $contrasena;

        public function __construct(){
            
        }

        public function setNombre($nombre){
            
            $this->nombre = $nombre;
        }

        public function setContrasena($contrasena){
            
            $this->contrasena = $contrasena;
        }

        public function getNombre(){
            
            return $this->nombre;
        }

        public function getContrasena(){
            
            return $this->contrasena;
        }

        public static function obtenerUsuario($nombre){
            $objAccesoDatos = AccesoDatos::obtenerInstancia();
            $consulta = $objAccesoDatos->prepararConsulta("SELECT nombre, contrasena FROM usuario WHERE nombre=?");
            $consulta->execute(array($nombre));
    
            return $consulta->fetchAll(PDO::FETCH_CLASS, 'Usuario');
        }

        public static function obtenerNombresDeUsuarios(){
            $objAccesoDatos = AccesoDatos::obtenerInstancia();
            $consulta = $objAccesoDatos->prepararConsulta("SELECT nombre FROM usuario");
            $consulta->execute();
    
            return $consulta->fetchAll();
        }

        public static function guardarUsuario($usuario){
            $objAccesoDatos = AccesoDatos::obtenerInstancia();
            $consulta = $objAccesoDatos->prepararConsulta("INSERT INTO usuario(nombre, contrasena) VALUES (?,?)");
            $consulta->execute(array($usuario->getNombre(), $usuario->getContrasena()));
        }

        public function compararContrasena($contrasena){
            
            if($this->contrasena == $contrasena){
                return true;
            }
            else{
                return false;
            }
        }
    }

?>