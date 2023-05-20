
# Guía de Instalación del Proyecto Angular + Laravel

Esta guía te proporcionará los pasos necesarios para instalar y configurar un proyecto que utiliza Angular como frontend y Laravel como backend. Asegúrate de cumplir con los requisitos previos antes de comenzar.

## Requisitos Previos

- Node.js y npm instalados en tu sistema.
- Composer instalado en tu sistema.
- Servidor web compatible con Laravel (por ejemplo, Apache o Nginx).
- Base de datos compatible con Laravel (por ejemplo, MySQL, PostgreSQL).

## Pasos de Instalación

1. Clona el repositorio del proyecto desde GitHub:

```bash
git clone https://github.com/let-s-rol/Gamifica-front
```

2. Accede al directorio del proyecto:

```bash
cd <DIRECTORIO_DEL_PROYECTO>
```

3. Instala las dependencias de Angular:

```bash
cd frontend
npm install
```

4. Configura el archivo de variables de entorno de Angular:

```bash
cp .env.example .env
```
   - Edita el archivo `.env` y establece las variables de entorno necesarias (por ejemplo, URL del backend, credenciales de la base de datos).

5. Compila y construye la aplicación de Angular:

```bash
ng build --prod
```
   - Los archivos generados se guardarán en la carpeta `dist/` dentro del directorio `frontend/`.

6. Regresa al directorio principal del proyecto:

```bash
cd ..
```

7. Instala las dependencias de Laravel:

```bash
composer install
```

8. Configura el archivo de variables de entorno de Laravel:

```bash
cp .env.example .env
```
   - Edita el archivo `.env` y establece las variables de entorno necesarias (por ejemplo, conexión de la base de datos, configuración del correo electrónico).

9. Ejecuta las migraciones de la base de datos:

```bash
php artisan migrate
```

10. Ejecuta los seeders de la base de datos:

```bash
php artisan db:seed --class=card_khSeeder
php artisan db:seed --class:gameSeeder
```

11. Configura el servidor web para que apunte al directorio `public/` dentro del proyecto.

12. ¡Listo! Ahora puedes acceder a tu proyecto Angular + Laravel a través de la URL configurada en tu servidor web.


# Cronología del Proyecto de Gamificación

### Nivel 1: Creación de Funciones Básicas
En este nivel, nos enfocamos en la creación de las funciones básicas necesarias para el sitio web, tales como el inicio de sesión, registro, asignación de roles y cierre de sesión.

### Nivel 2: Desarrollo de la Interfaz de Usuario
En el segundo nivel, nos centramos en desarrollar la interfaz, poniendo especial énfasis en la experiencia del usuario con rol de alumno.

### Nivel 3: Mejoras en la Interfaz y Roles
En el tercer nivel, realizamos ajustes adicionales en la interfaz y nos enfocamos en mejorar la experiencia de los usuarios con el rol de profesor.

### Nivel 4: Ampliación de Funcionalidades para el Ranking
En este nivel, llevamos a cabo un trabajo exhaustivo para agregar numerosas funcionalidades a la aplicación, específicamente enfocadas en el ranking.

### Nivel 5: Mejora de la Seguridad y SEO
En el quinto nivel, nos dedicamos a fortalecer la seguridad en el backend y optimizar el SEO en el frontend.

### Nivel 6: Documentación del Proyecto
Finalmente, en el sexto y último nivel, nos encargamos de realizar la documentación completa del proyecto.

