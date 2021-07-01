<?php
    class Mensaje{

        public $destino;
        public $usuario;
        public $contenido;


        public function __construct(){
            
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

        public function getDestino(){
            
            return $this->destino;
        }

        public function getUsuario(){
            
            return $this->usuario;
        }

        public function getContenido(){
            
            return $this->contenido;
        }


        
    }
?>