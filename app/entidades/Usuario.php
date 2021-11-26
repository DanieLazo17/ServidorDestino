<?php

    class Usuario{
        
        private $idUsuario;
        private $correo;
        private $nombre;
        private $contrasena;

        function __construct(){
            
        }

        function setCorreo($correo){
            
            $this->correo = $correo;
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

        function getCorreo(){
            
            return $this->correo;
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

        public function guardarUsuario(){
            $objAccesoDatos = AccesoDatos::obtenerInstancia();
            $consulta = $objAccesoDatos->prepararConsulta("INSERT INTO usuario(correo, nombre, contrasena) VALUES (?,?,?)");
            $consulta->execute(array($this->correo, $this->nombre, $this->contrasena));
        }

        public function compararContrasena($contrasenaIngresada){
            
            return password_verify($contrasenaIngresada, $this->getContrasena());
        }

        public function actualizarContrasena(){
            $objAccesoDatos = AccesoDatos::obtenerInstancia();
            $consulta = $objAccesoDatos->prepararConsulta("UPDATE usuario SET contrasena = ? WHERE idUsuario = ?");
            
            return $consulta->execute(array($this->contrasena, $this->idUsuario));
        }

        public static function obtenerUsuario($nombre){
            $objAccesoDatos = AccesoDatos::obtenerInstancia();
            $consulta = $objAccesoDatos->prepararConsulta("SELECT idUsuario, nombre, contrasena FROM usuario WHERE nombre=?");
            $consulta->execute(array($nombre));
            /*$consulta->setFetchMode(PDO::FETCH_CLASS, 'Usuario');*/
    
            /*return $consulta->fetch();*/
            return $consulta->fetch(PDO::FETCH_ASSOC);
        }

        public static function obtenerNombresDeUsuarios(){
            $objAccesoDatos = AccesoDatos::obtenerInstancia();
            $consulta = $objAccesoDatos->prepararConsulta("SELECT nombre FROM usuario");
            $consulta->execute();
    
            return $consulta->fetchAll();
        }

        public static function buscarCorreo($correo){
            $objAccesoDatos = AccesoDatos::obtenerInstancia();
            $consulta = $objAccesoDatos->prepararConsulta("SELECT idUsuario, correo FROM usuario WHERE correo=?");
            $consulta->execute(array($correo));
            $consulta->setFetchMode(PDO::FETCH_CLASS, 'Usuario');

            return $consulta->fetch();
        }
    }

?>