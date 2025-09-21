#  CRUD de Estudiantes en PHP (Patrón MVC) 📚

Este proyecto es una aplicación web completa para la gestión de una base de datos de estudiantes, implementando las cuatro operaciones básicas: **Crear, Leer, Actualizar y Borrar (CRUD)**. La aplicación fue desarrollada desde cero utilizando PHP puro y sigue el patrón de arquitectura **Modelo-Vista-Controlador (MVC)** para una clara separación de responsabilidades y un código más mantenible.

La interfaz de usuario es una *Single Page Application (SPA)*, lo que significa que todas las interacciones ocurren dinámicamente en una sola página sin necesidad de recargarla, gracias al uso de **AJAX con jQuery**.



---

## ✨ Características Principales

* **Arquitectura MVC:** Lógica de negocio (Modelo), presentación (Vista) y control de peticiones (Controlador) completamente separados.
* **CRUD Completo:** Funcionalidad completa para administrar registros de estudiantes.
* **Interfaz Dinámica (AJAX):** La tabla de estudiantes se actualiza en tiempo real después de cada operación sin recargar la página.
* **Seguridad (PDO):** Uso de consultas preparadas con PDO para prevenir ataques de inyección SQL.
* **Validación Dual:**
    * **Validación en el Cliente (JavaScript):** Notifica al usuario sobre campos obligatorios vacíos antes de enviar los datos.
    * **Validación en el Servidor (PHP):** Asegura la integridad de los datos y previene el registro de información incompleta, incluso si la validación del cliente es omitida.
* **Componentes sin Frameworks:** Los modales y otros elementos interactivos fueron construidos con HTML, CSS y jQuery, sin depender de frameworks como Bootstrap.
* **Enrutador Front Controller:** Un único punto de entrada (`index.php`) gestiona todas las peticiones de la aplicación.

---

## 🛠️ Tecnologías Utilizadas

* **Backend:** PHP 7.4+
* **Base de Datos:** MySQL
* **Frontend:** HTML5, CSS3, JavaScript
* **Librerías:** jQuery 3.7+ (para AJAX y manipulación del DOM)
* **Servidor:** Apache (a través de XAMPP, WAMP, MAMP o similar)

---

## 🚀 Instalación y Ejecución

Sigue estos pasos para ejecutar el proyecto en tu entorno local.

### Requisitos

* Un servidor web local como [XAMPP](https://www.apachefriends.org/index.html), WAMP o MAMP.
* MySQL (normalmente incluido en los paquetes anteriores).
* Un navegador web.

### Pasos

1.  **Clonar el repositorio** o descargar el archivo ZIP.
    ```bash
    git clone [URL_DE_TU_REPOSITORIO]
    ```

2.  **Mover el proyecto** a la carpeta de tu servidor web (normalmente `htdocs` en XAMPP o `/var/www/html` en Linux).

3.  **Crear la base de datos:**
    * Abre phpMyAdmin (o tu gestor de DB preferido).
    * Crea una nueva base de datos llamada `examen`.

4.  **Crear la tabla `estudiantes`:**
    * Selecciona la base de datos `examen`.
    * Ve a la pestaña SQL y ejecuta el siguiente script:
    ```sql
    CREATE TABLE `estudiantes` (
      `cedula` VARCHAR(20) NOT NULL,
      `nombre` VARCHAR(100) NOT NULL,
      `apellido` VARCHAR(100) NOT NULL,
      `direccion` VARCHAR(200) DEFAULT NULL,
      `telefono` VARCHAR(20) DEFAULT NULL
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

    ALTER TABLE `estudiantes`
      ADD PRIMARY KEY (`cedula`);
    ```

5.  **(Opcional) Insertar datos de prueba:**
    ```sql
    INSERT INTO `estudiantes` (`cedula`, `nombre`, `apellido`, `direccion`, `telefono`) VALUES
    ('1850596303', 'Carlos', 'Ramos Jacome', 'Baños de Agua Santa', '0967977374');
    ```

6.  **Configurar la conexión:**
    * Si tus credenciales de MySQL no son las estándar (`root` sin contraseña), abre el archivo `model/Database.php` y actualiza las variables `$user` y `$password`.

7.  **Ejecutar la aplicación:**
    * Abre tu navegador y ve a `http://localhost/[NOMBRE_DE_LA_CARPETA_DEL_PROYECTO]/`.

---

## 📂 Estructura de Archivos

El proyecto está organizado siguiendo la estructura MVC:

```
/
|-- assets/
|   |-- css/
|       |-- style.css
|-- controller/
|   |-- StudentController.php
|-- model/
|   |-- Database.php
|   |-- Student.php
|-- view/
|   |-- studentsView.php
|-- index.php
|-- README.md
```

---

Hecho con ❤️ para fines educativos.