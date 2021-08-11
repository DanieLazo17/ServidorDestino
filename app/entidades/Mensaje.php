<?php
    class Mensaje{

        private $idMensaje;
        private $destino;
        private $usuario;
        private $contenido;


        public function __construct(){
            
        }

        public function setIdMensaje($idMensaje){
            
            $this->idMensaje = $idMensaje;
        }

        public function setDestino($destino){
            
            $this->destino = $destino;
        }

        public function setUsuario($usuario){
            
            $this->usuario = $usuario;
        }

        public function setContenido($contenido){
            
            $this->contenido = $contenido;
        }

        public function getIdMensaje(){
            
            return $this->idMensaje;
        }

        public function getDestino(){
            
            return $this->destino;
        }

        public function getUsuario(){
            
            return $this->usuario;
        }

        public function getContenido(){
            
            return $this->contenido;
        }

        public function guardarMensaje(){
            $objAccesoDatos = AccesoDatos::obtenerInstancia();
            $consulta = $objAccesoDatos->prepararConsulta("INSERT INTO mensaje(destino, usuario, contenido) VALUES (?,?,?)");
            $consulta->execute(array($this->destino, $this->usuario, $this->contenido));
        }

        public function modificarMensaje(){
            $objAccesoDatos = AccesoDatos::obtenerInstancia();
            $consulta = $objAccesoDatos->prepararConsulta("UPDATE mensaje SET contenido = ? WHERE destino = ? AND usuario = ?");
            $consulta->execute(array($this->contenido, $this->destino, $this->usuario));
        }
        //Modificar métodos estáticos y revisar campo destino en base de datos
        public static function borrarMensaje($destino){
            $objAccesoDatos = AccesoDatos::obtenerInstancia();
            $consulta = $objAccesoDatos->prepararConsulta("DELETE FROM mensaje WHERE destino = ?");
            $consulta->execute(array($destino));
        }

        public static function obtenerMensajes(){
            $objAccesoDatos = AccesoDatos::obtenerInstancia();
            $consulta = $objAccesoDatos->prepararConsulta("SELECT * FROM mensaje");
            $consulta->execute();
    
            /*return $consulta->fetchAll(PDO::FETCH_CLASS, 'Mensaje');*/
            return $consulta->fetchAll(PDO::FETCH_ASSOC);
        }

        public static function obtenerMensajesDeDestino($idDestino){

            $objAccesoDatos = AccesoDatos::obtenerInstancia();
            $consulta = $objAccesoDatos->prepararConsulta("SELECT * FROM mensaje WHERE destino = ?");
            $consulta->execute(array($idDestino));
    
            /*return $consulta->fetchAll(PDO::FETCH_CLASS, 'Mensaje');*/
            return $consulta->fetchAll(PDO::FETCH_ASSOC);
        }
        
    }
?>