# 🎮 TestPlay

**TestPlay** es una plataforma web de alquiler temporal y prueba de videojuegos digitales, desarrollada con **PHP** siguiendo el patrón **MVC**. Aunque se incluyen títulos también disponibles en consolas como PlayStation o Xbox, **solo están disponibles en su versión para PC**, ya que estamos iniciando en el sector y nos centramos exclusivamente en juegos para ordenador (Windows).

---

## 👤 Funcionalidades de usuarios
- Registro e inicio de sesión
- Buscar videojuegos por título o categoría.
- Reservar y devolver videojuegos (con control de disponibilidad).
- Marcar videojuegos como probados.
- Puntuar del 1 al 10.
- Comentar en los videojuegos.
- Visualizar tráileres mediante YouTube (integrado en cada ficha).

## 👮 Funcionalidades de administradores
- Panel de control exclusivo.
- Gestión de videojuegos, reservas y préstamos.
- Revisión de puntuaciones y comentarios de usuarios.

## ⚙️ Tecnologías utilizadas
- PHP
- MySQL
- HTML, CSS, BootStrap(Framework para CSS), JavaScript (AJAX)
- YouTube Embeds para mostrar tráileres
- Visual Studio Code

## 📦 Estructura del proyecto
- `index.php` → Punto de entrada principal. Redirige según el rol de usuario.
- `controladores/` → Lógica de negocio (MVC).
- `modelos/` → Clases DAO y entidades.
- `vistas/` → Archivos HTML y lógica de presentación.
- `img/` → Imágenes de portada de los videojuegos.
- `js/` → Scripts JavaScript (incluye AJAX para acciones como marcar probado, comentar, puntuar).
- `config.php` → Configuración de la base de datos y constantes globales.

## 💾 Requisitos
- Servidor web local (Apache/Nginx)
- PHP 8.x
- MySQL
- phpMyAdmin (opcional, para gestionar la base de datos)

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
   git clone https://github.com/tu-usuario/TestPlay.git

3. Abre la carpeta del proyecto en tu editor o servidor local.

#### 📁 Configurar entorno

1. Copia el contenido del proyecto dentro del directorio htdocs (si usas XAMPP) o el equivalente en tu servidor.

2. Crea una base de datos en phpMyAdmin llamada TestPlayMVC.

3. Importa el archivo .sql con la estructura de la base de datos (si tienes uno).

4. Configura el archivo config.php con los datos de tu base de datos:

- `define('BD_USUARIO', 'root');`
- `define('BD_PASSWORD', '');`
- `define('BD_NOMBRE_BD', 'TestPlayMVC');`
- `define('BD_SERVIDOR', 'localhost');`

#### 🚀 Ejecutar el proyecto
- Abre tu navegador y ve a:

  ```bash
  http://localhost/TestPlay/index.php

✅ ¡Listo! Ya puedes comenzar a utilizar TestPlay, la plataforma de prueba y alquiler de videojuegos para PC.

---

## 📌 Nota importante
TestPlay ofrece únicamente versiones para PC. Aunque algunos juegos también estén disponibles en consolas, solo alquilamos y gestionamos la versión para ordenador (Windows). Esto permite simplificar el catálogo y la logística de la plataforma en su fase inicial.

## 👨‍💻 Autor
Proyecto académico creado por [Carlos Moraleda Ruiz],
Instituto: [I.E.S. Juan Bosco],
Asignatura: Desarrollo de Aplicaciones Web.
