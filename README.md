# 🎬 Cinema Click

Proyecto web de gestión de videoclub desarrollado con PHP y el patrón MVC.

## 👤 Funcionalidades de usuarios
- Registro e inicio de sesión
- Buscar películas por título o categoría
- Reservar y devolver películas
- Marcar películas como vistas
- Comentar y puntuar

## 👮 Funcionalidades de administradores
- Gestión de películas, reservas y préstamos
- Comentarios de usuarios
- Panel de control exclusivo en `configuraciones.php`

## ⚙️ Tecnologías utilizadas
- PHP
- MySQL
- HTML, CSS, JavaScript (AJAX)
- Visual Studio Code

## 📦 Estructura del proyecto
- `index.php` → Punto de entrada para usuarios y administradores en función del rol que tengan
- `modelos/`, `controladores/`, `vistas/` → Estructura MVC

## 💾 Requisitos
- Servidor web Apache/Nginx
- PHP 8.x
- MySQL

----

## 🛠️ Instalación local paso a paso

#### Requisitos previos

- Tener instalado:
  - Un servidor web local como **XAMPP**, **WAMP**, **Laragon** o **LAMP**
  - **PHP 8.x**
  - **MySQL**
  - **Git** (opcional, pero recomendable)

#### 📥 Clonar el repositorio

1. Abre Visual Studio Code o tu terminal.
2. Clona el repositorio con:

   ```bash
   git clone https://github.com/tu-usuario/Cinema_Click.git

3. Abre la carpeta del proyecto en tu editor o servidor local.

#### 📁 Configurar entorno

1. Copia el contenido del proyecto dentro del directorio htdocs (si usas XAMPP) o el equivalente en tu servidor.

2. Crea una base de datos en phpMyAdmin llamada CinemaClickMVC.

3. Importa el archivo .sql con la estructura de la base de datos (si tienes uno).

4. Configura el archivo config.php con los datos de tu base de datos:

- `define('BD_USUARIO', 'root');`
- `define('BD_PASSWORD', '');`
- `define('BD_NOMBRE_BD', 'CinemaClickMVC');`
- `define('BD_SERVIDOR', 'localhost');`

#### 🚀 Ejecutar el proyecto
- Abre tu navegador y ve a:

  ```bash
  http://localhost/Cinema_Click/index.php

✅ ¡Listo! Ya puedes empezar a probar el sistema de videoclub.
