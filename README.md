## RugbyApp ##

Esta aplicacion de **rugby** permite gestionar ligas, equipos y jugadores. Aparte dispone de usuarios para acceder a la aplicacion.

### Instalacion ###

Para poder instalar la aplicacion desde un terminal de linux o terminal git realiza un `"`$ git clone https://github.com/Anmoysan/LigaRugbyEspanolV2.git `"` e importa la ultima version del proyecto a tu equipo.

Para poder usar correctamente la aplicacion debe terner instalado composer de manera nativa, también debe terner de manera nativa apache o en su caso tener instalado una aplicacion como MAMP y meter el proyecto en su carpeta localhost.

### Configuracion ###

Si tiene un MAMP debe seleccionar la version de PHP desde `"`Preferences`"`/`"`PHP`"` y ahi selecciona la versión. Además en `"`Preferences`"`/`"`WebServer`"` se debe indicar la carpeta del proyecto y dentro seleccionar la carpeta "public".

Se debe crear una base de datos con el nombre que prefiera y dentro se debe importar un archivo llamado `"`createdb.sql`"v situado en la carpeta del proyecto. Lo que nos permitira crear todas las tablas y sus datos correspondientes.

Tambien en la carpeta del proyecto hay un archivo llamado ".env.example" que se debe usar como ejemplo para crear un archivo `"`.env`"` para linux y `"`env`"` en Windows para evitar errores y rellenar los datos con sus valores correspondientes.

En el index.php en la linea 22 y 23 si es linux debera ser:

>if(file_exists(__DIR__.'/../.env')){
>>   $dotenv = new Dotenv\Dotenv(__DIR__.'/..');

![env Linux](https://imgur.com/uP6I4BF.png)

Si es un Windows debera ser:

>if(file_exists(__DIR__.'/../env')){
>>   $dotenv = new Dotenv\Dotenv(__DIR__.'/..', 'env');

![env Windows](https://imgur.com/8iRm5P6.png)

**Aviso:** Algunas Windows permiten la forma de linux pero otros no. Depende del Window se puede de una manera u otra.

Por ultimo se debe acceder a la terminal del editor del programa y ejecutar el comando `"`composer install`"`. Una vez ejecutado se debe esperar un poco.

### Uso ###

Desde cualquier página aparecera una barra arriba de navegacion donde nos permitira movernos rapidamente desde las paginas. Aparte exite una barra de búsqueda actualmente fura de funcionamiento y un menu desplegable llamado `"`Acceso`"`.

Desde `"`Acceso`"` se puede acceder a dos funciones llamadas login y registro que nos permite crear o acceder a nuestro usuario. Si accedemos a nuestro usuario `"`Acceso`"` se habra cambiado por el nombre de tu usuario y en vez de login y registro aparecera `"`Cerrar Sesion`"`.
![Loggueado](https://imgur.com/BYTvSJO.png)
![Sin loguear](https://imgur.com/59c9pS9.png)

Si no se esta loggueado solo se puede ver las ligas, equipos y jugadores, por el contrario se esta loggueado se puede crear una entidad desde donde se quiere guardar.
Ej: Si se quiere crear un equipos se debe hacer desde una liga.

![Pantalla Inicio](https://imgur.com/TE1mSZO.png)

Para modificar y eliminar una entidad se debe hacer desde dentro de la entidad explicita. Ej: Si se quiere eliminar un jugador debe acceder a ese jugador y existira un boton a la izquierda que se llame `"`Eliminar Jugador `"`.

![Pantalla Inicio](https://imgur.com/YvnxeFn.png)

Al crear alguna entidad si añade algún dato mal la pagina se lo indicará al enviar los datos. Si la imagen que se ha enviado no existe se le añadira una imagen por defecto que indica que no tiene imagen. También en equipo y liga si no se añade explicitamente liga o equipo se añadira automaticamente.

### Diseño ###

Desde la página de inicio se puede ver como se muestra unas ligas con sus imagenes. Si Seleccionamos una nos mostrará los datos de esa liga en concreto y los equipos que jueguen esa liga.

De igual forma si accedemos a un equipo nos mostrará sus datos y los jugadores existentes en ese equipo. Si entramos en un jugador nos enseñará sus datos personales y sus datos técnicos(*datos de partidos*).

![Pantalla Inicio](https://imgur.com/eEwr9dT.png)

###**Espero que les sea de ayuda y gracias por usar esta aplicacion**###
