# Gestion Deportiva - Proyecto PHP MVC

Aplicacion web para la gestion de equipos de futbol y jugadores. Este proyecto ha sido desarrollado utilizando arquitectura MVC (Modelo-Vista-Controlador) con PHP nativo y MySQL.

## URL del Proyecto
Puedes ver la aplicacion funcionando en el siguiente enlace:
[PEGAR AQUI LA URL DE TU HOSTING]

## Descripcion
El objetivo de la aplicacion es permitir a los usuarios registrar su propio equipo de futbol y gestionar su plantilla. La web cuenta con una parte publica (visible para todos) y una parte privada (panel de administracion).

### Funcionalidades Principales
- Arquitectura MVC: Separacion del codigo en Modelo, Vista y Controlador.
- Base de Datos: Gestion mediante PDO y sentencias preparadas.
- Autenticacion: Sistema de registro y login con contraseñas encriptadas.
- CRUD: Crear, Leer, Actualizar y Borrar jugadores y equipos.
- Imagenes: Subida y almacenamiento de escudos en la base de datos.
- Frontend: Interfaz responsiva con despliegue de detalles de jugadores.

## Tecnologias Utilizadas
- Lenguaje: PHP
- Base de Datos: MySQL
- Frontend: HTML5, CSS3
- Control de Versiones: Git

## Tutorial de Uso
A continuacion se detallan los pasos para probar la aplicacion:

1. Inicio: En la pantalla principal se ven todos los equipos. Al hacer clic sobre el nombre de un jugador, se despliegan sus estadisticas (peso, altura, edad).
2. Registro: Accede a "Registrarse" para crear un equipo nuevo. Es obligatorio subir una imagen para el escudo.
3. Login: Accede con tu email y contraseña.
4. Gestion: Una vez dentro, usa el boton "Añadir Jugador" para agregar miembros a tu equipo. Usa los botones de "Editar" o "Borrar" para gestionar la plantilla.
5. Perfil: En la seccion "Perfil" puedes actualizar los datos del estadio o eliminar tu cuenta y todos tus datos permanentemente.

### Credenciales de prueba
Si deseas probar la aplicacion sin realizar el registro, puedes usar este usuario administrador:

- Email: malagacf@gmail.com
- Contraseña: 1234

## Instalacion en local
1. Clonar este repositorio.
2. Importar el archivo SQL adjunto en su gestor de base de datos.
3. Configurar los datos de conexion en el archivo de configuracion de la base de datos.
4. Ejecutar en un servidor local (Apache/XAMPP).