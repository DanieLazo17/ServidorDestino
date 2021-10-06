<?php
    error_reporting(-1);
    ini_set('display_errors', 1);

    use Psr\Http\Message\ResponseInterface as Response;
    use Psr\Http\Message\ServerRequestInterface as Request;
    use Psr\Http\Server\RequestHandlerInterface;
    use Slim\Factory\AppFactory;
    use Slim\Routing\RouteCollectorProxy;
    use Slim\Routing\RouteContext;

    require __DIR__ . '/../vendor/autoload.php';

    require __DIR__ . '/accesoADatos/AccesoDatos.php';
    require __DIR__ . '/funciones/funciones.php';
    require __DIR__ . '/entidades/Usuario.php';
    require __DIR__ . '/entidades/Destino.php';
    require __DIR__ . '/entidades/Mensaje.php';
    require __DIR__ . '/controlador/UsuarioControlador.php';
    require __DIR__ . '/controlador/DestinoControlador.php';
    require __DIR__ . '/controlador/MensajeControlador.php';

    //Crear un objeto
    $app = AppFactory::create();

    //Interceptar paquete entrante
    $app->addErrorMiddleware(true,true,true);

    // Habilitar CORS
    $app->add(function (Request $request, RequestHandlerInterface $handler): Response {
        // $routeContext = RouteContext::fromRequest($request);
        // $routingResults = $routeContext->getRoutingResults();
        // $methods = $routingResults->getAllowedMethods();
        
        $response = $handler->handle($request);
    
        $requestHeaders = $request->getHeaderLine('Access-Control-Request-Headers');
    
        $response = $response->withHeader('Access-Control-Allow-Origin', '*');
        $response = $response->withHeader('Access-Control-Allow-Methods', 'get,post,put');
        $response = $response->withHeader('Access-Control-Allow-Headers', $requestHeaders);
    
        // Optional: Allow Ajax CORS requests with Authorization header
        // $response = $response->withHeader('Access-Control-Allow-Credentials', 'true');
    
        return $response;
    });

    $app->get('[/]', function (Request $request, Response $response, array $args) {
        $response->getBody()->write("Bienvenido");
        return $response;
    });

    //Usuario
    $app->group("/Usuario", function (RouteCollectorProxy $grupoUsuario) {
        $grupoUsuario->post("[/]", \UsuarioControlador::class . ':ValidarUsuario' );
        $grupoUsuario->post("/Verificacion[/]", \UsuarioControlador::class . ':RetornarUsuario' );
        $grupoUsuario->post("/Nuevo[/]", \UsuarioControlador::class . ':BuscarNombreDeUsuario' );
        $grupoUsuario->post('/Registro[/]', \UsuarioControlador::class . ':CrearUsuario' );
    });
    
    //Destino
    $app->group('/Destino', function (RouteCollectorProxy $grupoDestino) {
        $grupoDestino->post('/Nuevo[/]', \DestinoControlador::class . ':CrearDestino' );
        $grupoDestino->get('[/]', \DestinoControlador::class . ':RetornarDestinos' );
        $grupoDestino->get('/{idDestino}[/]', \DestinoControlador::class . ':RetornarDestino' );
        $grupoDestino->post('/Nombre[/]', \DestinoControlador::class . ':BuscarDestinoPorNombre' );
        $grupoDestino->get('/Popular[/]', \DestinoControlador::class . ':TraerDestinosOrdenados' );
    });

    //Mensaje
    $app->group('/Mensaje', function (RouteCollectorProxy $grupoMensaje) {
        $grupoMensaje->post('[/]', \MensajeControlador::class . ':CrearMensaje' );
        $grupoMensaje->get('/Destino/{idDestino}[/]', \MensajeControlador::class . ':RetornarMensajesDeDestino' );
        $grupoMensaje->get('/Usuario/{idUsuario}[/]', \MensajeControlador::class . ':RetornarMensajesDeUsuario' );
        $grupoMensaje->get('[/]', \MensajeControlador::class . ':RetornarMensajes' );
        //Revisar método patch() o put()
        $grupoMensaje->post('/{idMensaje}[/]', \MensajeControlador::class . ':ActualizarMensaje' );
        $grupoMensaje->delete('/Borrar/{idMensaje}', \MensajeControlador::class . ':BorrarMensaje' );
    });

    $app->post('/hello/{name}', function (Request $request, Response $response, array $args) {
        $name = $args['name'];
        $response->getBody()->write("Hello, $name");
        return $response;
    });

    $app->run();
?>