<?php
    class Mensaje{

        private $idMensaje;
        private $destino;
        private $usuario;
        private $contenido;
        private $fecha;

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

        public function setFecha($fecha){
            
            $this->fecha = $fecha;
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

        public function getFecha(){
            
            return $this->fecha;
        }

        public function guardarMensaje(){
            $objAccesoDatos = AccesoDatos::obtenerInstancia();
            $consulta = $objAccesoDatos->prepararConsulta("INSERT INTO mensaje(idMensaje, destino, usuario, contenido, fecha) VALUES (?,?,?,?,?)");
            $consulta->execute(array($this->idMensaje, $this->destino, $this->usuario, $this->contenido, $this->fecha));
        }

        public function modificarMensaje(){
            $objAccesoDatos = AccesoDatos::obtenerInstancia();
            $consulta = $objAccesoDatos->prepararConsulta("UPDATE mensaje SET contenido = ?, destino = ? WHERE idMensaje = ?");
            $consulta->execute(array($this->contenido, $this->destino, $this->idMensaje));
        }
        
        public function borrarMensaje(){
            $objAccesoDatos = AccesoDatos::obtenerInstancia();
            $consulta = $objAccesoDatos->prepararConsulta("DELETE FROM mensaje WHERE idMensaje = ?");
            $consulta->execute(array($this->idMensaje));
        }

        public function obtenerMensajesDeDestino(){
            $objAccesoDatos = AccesoDatos::obtenerInstancia();
            $consulta = $objAccesoDatos->prepararConsulta("SELECT m.idMensaje, d.nombre AS destino, u.nombre AS usuario, m.contenido, fecha FROM mensaje AS m, usuario AS u, destino AS d WHERE m.destino = d.idDestino AND m.usuario = u.idUsuario AND m.destino = ?");
            $consulta->execute(array($this->destino));
    
            /*return $consulta->fetchAll(PDO::FETCH_CLASS, 'Mensaje');*/
            return $consulta->fetchAll(PDO::FETCH_ASSOC);
        }

        public function obtenerMensajesDeUsuario(){
            $objAccesoDatos = AccesoDatos::obtenerInstancia();
            $consulta = $objAccesoDatos->prepararConsulta("SELECT m.idMensaje, m.destino, m.usuario, m.contenido, m.fecha FROM mensaje AS m, usuario AS u, destino AS d WHERE m.destino = d.idDestino AND m.usuario = u.idUsuario AND m.usuario = ?");
            $consulta->execute(array($this->usuario));
    
            /*return $consulta->fetchAll(PDO::FETCH_CLASS, 'Mensaje');*/
            return $consulta->fetchAll(PDO::FETCH_ASSOC);
        }

        public static function obtenerMensajes(){
            $objAccesoDatos = AccesoDatos::obtenerInstancia();
            $consulta = $objAccesoDatos->prepararConsulta("SELECT * FROM mensaje");
            $consulta->execute();
    
            /*return $consulta->fetchAll(PDO::FETCH_CLASS, 'Mensaje');*/
            return $consulta->fetchAll(PDO::FETCH_ASSOC);
        }

        public static function obtenerUltimoIdMensaje(){
            $objAccesoDatos = AccesoDatos::obtenerInstancia();
            $consulta = $objAccesoDatos->prepararConsulta("SELECT MAX(idMensaje) AS idMensaje FROM mensaje");
            $consulta->execute();

            return $consulta->fetch(PDO::FETCH_ASSOC);
        }
    }
?>