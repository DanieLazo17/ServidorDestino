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

            Destino::guardarDestino($destino);

            $response->getBody()->write( json_encode($destino) );

            return $response;
        }

        public function RetornarDestinos($request, $response, $args){

            $arrayDestinos = Destino::obtenerDestinos();
            $response->getBody()->write(json_encode($arrayDestinos));
   
            return $response->withHeader('Content-Type', 'application/json');
        }

    }

?>