# Team Generator API Challenge

## Descripcion
A continuacion se daran instrucciones basicas para la instalacion de dicho proyecto y el stack utilizado.

## Tecnologia utilizada

- PHP >= 8.2
- Composer
- Laravel Framework 11
- Base de datos PostgreSQL
- PHPUnit

## Instrucciones a tener en cuenta

- Existe un archivo .env.example con las configuraciones basicas para el correcto funcionamiento del proyecto, ya sea url base, datos de conexion a la DB y el bearer token estatico para utilizar.
- Luego sera subido el .env.testing que va a servir para ejecutar los test unitarios y que no vacie la DB principal cuando se corran dichos tests.
- Existe el .env utilizado por mi para mi entorno local, pueden usar el mismo sin problemas.


## Descripciones generales a tener en cuenta en dicho challenge.

- Se trato de utilizar lo mejor posible los principios SOLID, para el mejor entendimiento del codigo y dicho mantenimiento.
- Se utiizo una estructura de carpetas y nomenclaturas en las clases y/o archivos teniendo en cuenta DDD, generando asi un desacoplamiento y una baja dependencia en el codigo.
- Se trato de aprovechar los estandares de Laravel que hoy propone para el presente desarrollo, como la utilizacion del standar RESTFUL de api, Enums, Resources y demas caracteristicas que laravel 11 hoy en dia recomienda utilizar.
- Sobre los tests unitarios creados, podrian haber sido muchisimos mas, solo quise mostrar el como trabajo con varios patrones de diseños y que cumpla con lo suficiente para el challenge
- Se creo un middleware especifico para la eliminacion de los jugadores y un static bearer token, ya que al no haber usuarios utilizar sanctum no era posible, fui por una solucion practica y sencilla de aplicar para un challenge.

