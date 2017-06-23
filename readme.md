Página interna de la Policía originalmente para [POPLife](http://plataoplomo.wtf).

Hecha con [Laravel](https://laravel.com), [Laravel Backpack](https://backpackforlaravel.com/) y [Materializecss](http://materializecss.com), entre otras cosas.

## Características

- **Inicio de sesión con Steam**
- Página de frecuencias para el TaskForce Radio con opción para regenerar
- Especializaciones
- Lista de toda la Policía
- Panel de control
- Sistema de páginas
- Sistema de quejas internas
- Sistema de condecoraciones
- Sistema de servicios

## Próximamente

- Notificaciones

## Cómo instalar

1. Instalar git
2. Instalar PHP (recomendado 7+)
3. Instalar [Composer](https://getcomposer.org/download/)
4. Instalar MYSQL

No hay ningún mecanismo de instalación. Hay que usar el mecanismo por defecto de Laravel:

1. `git clone git@github.com:Apecengo/policia.git`
2. En la carpeta: `composer install`, `php artisan key:generate`
3. Copiar `.env.example` a `.env`
4. Editar `.env` con detalles de la base de datos, correo, [Clave API de Steam](http://steamcommunity.com/dev/apikey) y Google Analytics.
5. Generar base de datos: `php artisan migrate`
5. Acceder a la base de datos y crear un usuario con [nuestra SteamID](https://steamid.io)

Hacer que el servidor web apunte a la carpeta `public`. Acceder.

Comprobar que no salten errores y cambiar de `.env`:

- `APP_ENV=production`
- `APP_DEBUG=true`
- `APP_URL` a la dirección de la página
- `MAIL_FROM_ADDRESS=notificaciones@tudominio`
- `MAIL_FROM_NAME="Nombre de la página"`

Crea un cronjob con lo siguiente:

`* * * * * php /carpeta-de-instalacion/artisan schedule:run >> /dev/null 2>&1`

Ojo a los permisos: el usuario del servidor web debe tener acceso de lectura y escritura, pero también el del cronjob.

## Incidencias

https://github.com/Apecengo/policia/issues

## Licencia

MIT

```
Copyright 2017 Apecengo/Manolo Pérez

Permission is hereby granted, free of charge, to any person obtaining a copy of this software and associated documentation files (the "Software"), to deal in the Software without restriction, including without limitation the rights to use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies of the Software, and to permit persons to whom the Software is furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
```
