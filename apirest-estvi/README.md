# Cumplimiento de actividades

### Crear un segundo modulo que exponga un CRUD de servicios Restful que permita alterar la información de la tabla generada, el path debe ser /example-crud/data.

En este punto logre exponer la petición GET para la constula de datos.
Para hacer la petición GET posible cree los archivos de configuración correspondiente, estos son el .info.yml, .module y .rounting.yml.
En la configuración de rutas se hace lo siguiente:

```sh
apirest_estvi.example_crud_data:
  path: '/example-crud/data'
  defaults:
    _controller: '\Drupal\apirest_estvi\Controller\CrudController::getData'
  method: [GET]
  requirements:
    _permission: 'access content'  
    
```
A través del controlador CrudController se hace el llamado a la función getData, donde se recibe un varaible de tipo Request, se hace la consulta en la base de datos para retornar todos los valores y se proporcionan los valores en estructura JSON.
```sh

  public function getData(Request $request){
        try {

            $contenido = $request->getContent();
            $params = json_decode($contenido, true);

            $query = $this->cn->select('example_users', 'users');
            $query->fields('users', ['id', 'nombre', 'identificacion', 'fecha_nacimiento', 'cargo_usuario', 'Estado']);
            $valores = $query->execute();
            $resultados = $valores->fetchAll();

            $respuesta_api = array(
                "status" => "OK",
                "message" => "Usuarios registrados",
                "result" => $resultados,
            );
            return new JsonResponse($respuesta_api);

        } catch (Exception $ex) {
            dpm($ex->getMessage());
        }

