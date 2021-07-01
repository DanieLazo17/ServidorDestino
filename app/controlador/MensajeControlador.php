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

        public function RetornarMensajes($request, $response, $args){

            $arrayMensajes = Mensaje::obtenerMensajes();
            $response->getBody()->write(json_encode($arrayMensajes));
   
            return $response->withHeader('Content-Type', 'application/json');
        }

        public function ActualizarMensaje($request, $response, $args){
            $listaDeParametros = $request->getParsedBody();
            $destino = $listaDeParametros['destino'];
            $usuario = $listaDeParametros['usuario'];
            $contenido = $listaDeParametros['contenido'];

            $mensaje = new Mensaje();
            $mensaje->setDestino($destino);
            $mensaje->setUsuario($usuario);
            $mensaje->setContenido($contenido);

            $mensaje->modificarMensaje();

            $response->getBody()->write( json_encode($mensaje) );

            return $response;
        }

        public function BorrarMensaje($request, $response, $args){

            $destino = $args['destino'];

            Mensaje::borrarMensaje($destino);

            $response->getBody()->write("borrado");
   
            return $response;
        }
        
    }

?>