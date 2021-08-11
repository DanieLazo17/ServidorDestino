<?php
    class Destino {
  
        private $idDestino;
        private $nombre;
        private $tipoTurismo;
        private $pais;
        private $provincia;
        private $alojamiento;
        private $comida;
        private $comunidad;
        private $imagenpath;

        public function __construct(){
            
        }

        public function setIdDestino($idDestino){
            
            $this->idDestino = $idDestino;
        }

        public function setNombre($nombre){
            
            $this->nombre = $nombre;
        }

        public function setTipoTurismo($tipoTurismo){
            
            $this->tipoTurismo = $tipoTurismo;
        }

        public function setPais($pais){
            
            $this->pais = $pais;
        }

        public function setProvincia($provincia){
            
            $this->provincia = $provincia;
        }

        public function setAlojamiento($alojamiento){
            
            $this->alojamiento = $alojamiento;
        }

        public function setComida($comida){
            
            $this->comida = $comida;
        }

        public function setComunidad($comunidad){
            
            $this->comunidad = $comunidad;
        }

        public function setImagenpath($imagenpath){
            
            $this->imagenpath = $imagenpath;
        }

        public function getNombre(){
            
            return $this->nombre;
        }

        public function getIdDestino(){
            
            return $this->idDestino;
        }

        public function getTipoTurismo(){
            
            return $this->tipoTurismo;
        }

        public function getPais(){
            
            return $this->pais;
        }

        public function getProvincia(){
            
            return $this->provincia;
        }

        public function getAlojamiento(){
            
            return $this->alojamiento;
        }

        public function getComida(){
            
            return $this->comida;
        }

        public function getComunidad(){
            
            return $this->comunidad;
        }

        public function getImagenpath(){
            
            return $this->imagenpath;
        }

        public function guardarDestino(){
            $objAccesoDatos = AccesoDatos::obtenerInstancia();
            $consulta = $objAccesoDatos->prepararConsulta("INSERT INTO destino(nombre, tipoTurismo, pais, provincia) VALUES (?,?,?,?)");
            $consulta->execute(array($this->nombre, $this->tipoTurismo, $this->pais, $this->provincia));
        }

        public static function obtenerDestinos(){
            $objAccesoDatos = AccesoDatos::obtenerInstancia();
            $consulta = $objAccesoDatos->prepararConsulta("SELECT * FROM destino");
            $consulta->execute();
            //$arregloDeDestinosEncapsulados = $consulta->fetchAll(PDO::FETCH_CLASS, 'Destino');
            $arregloDeDestinos = $consulta->fetchAll(PDO::FETCH_ASSOC);
            /*
            $arregloDeDestinos = array();
            $es = "set";

            foreach($arregloDeDestinosEncapsulados as $objetoDeDestino){

                $objetoDestinoTemp = new Destino();

                foreach($objetoDeDestino as $atr => $valueAtr){
                    $es = $es . ucfirst($atr);
                    $objetoDestinoTemp->{$es}($valueAtr);
                    $es = "set";
                }
                array_push($arregloDeDestinos, $objetoDestinoTemp);
            }
            */
            return $arregloDeDestinos;
        }
    }
?>