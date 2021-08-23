## Aplicación base
Repositorio base para realizar fork en nuevas aplicaciones.

## Instalación
### Instalación de paquetes
```bash
composer install
```

### Crear el archivo .env
```bash
cp .env.example .env
```
### Configurar el archivo .env colocando la dirección URL y sus credenciales para conectarse a la base de datos
```bash
APP_URL=http://laravel.test
.
.
.
DB_CONNECTION=mysql
DB_HOST=localhost
DB_PORT=3306
DB_DATABASE=<nombre de la db>
DB_USERNAME=<Usuario de la db>
DB_PASSWORD=<Contraseña de la db>
```
### Generar la clave de aplicación
```bash
php artisan key:generate
```
### Migrar las tablas de la base de datos junto con los datos iniciales.
```bash
php artisan migrate --seed
```

##### Nota: Cada vez que se actualice el archivo routes/api.php, o el archivo .env recordar correr el siguiente comando:

```bash
php artisan optimize
```

##### Links de utilidad
- [Documentación de laravel](https://laravel.com/docs/8.x)
- [Documentación de passport](https://laravel.com/docs/8.x/passport#introduction)
- [Documentación de spatie roles & permissions](https://spatie.be/docs/laravel-permission/v4/introduction)
- [Documentación de ArcaneDev/Log-viewer](https://github.com/ARCANEDEV/LogViewer)
- [Documentación de WildsideUK/Laravel-Userstamps](https://github.com/WildsideUK/Laravel-Userstamps)



