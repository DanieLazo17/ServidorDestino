<?php

    class DestinoControlador{

        public function CrearDestino($request, $response, $args){
            $listaDeParametros = $request->getParsedBody();
            $nombre = $listaDeParametros['nombre'];
            $tipoTurismo = $listaDeParametros['tipoTurismo'];
            $pais = $listaDeParametros['pais'];
            $provincia = $listaDeParametros['provincia'];

            $destino = new Destino();
            //$destino->nombre = $listaDeParametros['nombre'];
            //$destino->tipoTurismo = $listaDeParametros['tipoTurismo'];
            //$destino->pais = $listaDeParametros['pais'];
            //$destino->provincia = $listaDeParametros['provincia'];
            $destino->setNombre($nombre);
            $destino->setTipoTurismo($tipoTurismo);
            $destino->setPais($pais);
            $destino->setProvincia($provincia);

            $destino->guardarDestino();

            $response->getBody()->write( json_encode($destino) );

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
            $response->getBody()->write(json_encode($arregloDeDestino));
   
            return $response->withHeader('Content-Type', 'application/json');
        }
    }

?>