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

            $ObjetoMensaje = new Mensaje();
            $ObjetoMensaje->setDestino($idDestino);
            $arrayMensajes = $ObjetoMensaje->obtenerMensajesDeDestino();
            $response->getBody()->write(json_encode($arrayMensajes));
   
            return $response->withHeader('Content-Type', 'application/json');
        }

        public function RetornarMensajes($request, $response, $args){
            $arrayMensajes = Mensaje::obtenerMensajes();
            $response->getBody()->write(json_encode($arrayMensajes));
   
            return $response->withHeader('Content-Type', 'application/json');
        }

        public function ActualizarMensaje($request, $response, $args){
            $listaDeParametros = $request->getParsedBody();
            $idMensaje = $args['idMensaje'];

            $destino = $listaDeParametros['destino'];
            $contenido = $listaDeParametros['contenido'];

            $mensaje = new Mensaje();
            $mensaje->setIdMensaje($idMensaje);
            $mensaje->setDestino($destino);
            $mensaje->setContenido($contenido);
            $mensaje->modificarMensaje();

            $response->getBody()->write( json_encode($mensaje) );
            return $response;
        }

        public function BorrarMensaje($request, $response, $args){
            $idMensaje = $args['idMensaje'];

            $ObjetoMensaje = new Mensaje();
            $ObjetoMensaje->setIdMensaje($idMensaje);
            $ObjetoMensaje->borrarMensaje();

            $response->getBody()->write("borrado");
            return $response;
        }
        
        public function RetornarMensajesDeUsuario($request, $response, $args){
            $idUsuario = $args['idUsuario'];

            $ObjetoMensaje = new Mensaje();
            $ObjetoMensaje->setUsuario($idUsuario);
            $arrayMensajes = $ObjetoMensaje->obtenerMensajesDeUsuario();
            $response->getBody()->write(json_encode($arrayMensajes));
   
            return $response->withHeader('Content-Type', 'application/json');
        }
    }

?>