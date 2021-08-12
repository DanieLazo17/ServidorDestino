<?php

    class MensajeControlador{

        public function CrearMensaje($request, $response, $args){
            $listaDeParametros = $request->getParsedBody();
            $destino = $listaDeParametros['destino'];
            $usuario = $listaDeParametros['usuario'];
            $contenido = $listaDeParametros['contenido'];

            $mensaje = new Mensaje();
            $mensaje->setDestino($destino);
            $mensaje->setUsuario($usuario);
            $mensaje->setContenido($contenido);

            $mensaje->guardarMensaje();

            $response->getBody()->write( json_encode($mensaje) );

            return $response;
        }

        public function RetornarMensajesDeDestino($request, $response, $args){

            $idDestino = $args['idDestino'];

            $arrayMensajes = Mensaje::obtenerMensajesDeDestino($idDestino);
            $response->getBody()->write(json_encode($arrayMensajes));
   
            return $response->withHeader('Content-Type', 'application/json');
        }

        public function RetornarMensajes($request, $response, $args){

            $arrayMensajes = Mensaje::obtenerMensajes();
            $response->getBody()->write(json_encode($arrayMensajes));
   
            return $response->withHeader('Content-Type', 'application/json');
        }

        public function ActualizarMensaje($request, $response, $args){
            $listaDeParametros = $request->getBody();
            $idMensaje = $args['idMensaje'];

            $destino = $listaDeParametros['destino'];
            $contenido = $listaDeParametros['contenido'];

            $mensaje = new Mensaje();
            $mensaje->setDestino($destino);
            $mensaje->setContenido($contenido);

            $mensaje->modificarMensaje($idMensaje);

            $response->getBody()->write( json_encode($mensaje) );

            return $response;
        }

        public function BorrarMensaje($request, $response, $args){

            $idMensaje = $args['idMensaje'];

            Mensaje::borrarMensaje($idMensaje);

            $response->getBody()->write("borrado");
   
            return $response;
        }
        
    }

?>