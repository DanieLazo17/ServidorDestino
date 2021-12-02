<?php

    class DestinoControlador{

        public function CrearDestino($request, $response, $args){
            $listaDeParametros = $request->getParsedBody();
            $nombre = $listaDeParametros['nombre'];
            $tipoTurismo = $listaDeParametros['tipoTurismo'];
            $pais = $listaDeParametros['pais'];
            $provincia = $listaDeParametros['provincia'];

            //Normalizar datos
            $nombre = ucwords($nombre);
            $tipoTurismo = ucwords($tipoTurismo);
            $pais = ucwords($pais);
            $provincia = ucwords($provincia);

            $UltimoId = Destino::obtenerUltimoIdDestino();
            $UltimoId['idDestino'] += 1;

            $destino = new Destino();
            $destino->setIdDestino($UltimoId['idDestino']);
            $destino->setNombre($nombre);
            $destino->setTipoTurismo($tipoTurismo);
            $destino->setPais($pais);
            $destino->setProvincia($provincia);
            $destino->guardarDestino();

            $DestinoNuevo = array("idDestino"=>$UltimoId['idDestino']);

            $response->getBody()->write( json_encode($DestinoNuevo) );
            return $response;
        }

        public function RetornarDestinos($request, $response, $args){
            $arregloDeDestinos = Destino::obtenerDestinos();
            $response->getBody()->write(json_encode($arregloDeDestinos));
   
            return $response->withHeader('Content-Type', 'application/json');
        }

        public function RetornarDestino($request, $response, $args){
            $idDestino = $args['idDestino'];

            $Destino = new Destino();
            $Destino->setIdDestino($idDestino);
            $arregloDeDestino =$Destino->obtenerDestino();

            $response->getBody()->write(json_encode($arregloDeDestino));
            return $response->withHeader('Content-Type', 'application/json');
        }

        public function BuscarDestinoPorNombre($request, $response, $args){
            $listaDeParametros = $request->getParsedBody();
            $nombre = $listaDeParametros['nombre'];
            $arregloDeDestino = Destino::obtenerDestinoPorNombre($nombre);

            if(!$arregloDeDestino){
                $arregloDeDestino = array("idUsuario"=>null, "nombre"=>null);
            }
            
            $response->getBody()->write(json_encode($arregloDeDestino));
            return $response->withHeader('Content-Type', 'application/json');
        }

        public function TraerDestinosOrdenados($request, $response, $args){
            $arregloDeDestinos = Destino::obtenerDestinosOrdenados();
            $response->getBody()->write(json_encode($arregloDeDestinos));
   
            return $response->withHeader('Content-Type', 'application/json');
        }

        public function TraerDestinosPopulares($request, $response, $args){
            $arregloDeDestinos = Destino::obtenerDestinosPopulares();
            $response->getBody()->write(json_encode($arregloDeDestinos));
   
            return $response->withHeader('Content-Type', 'application/json');
        }
    }
?>