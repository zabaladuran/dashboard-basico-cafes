# Dashboard Básico Cafés

Este proyecto es un sistema web básico para la gestión de una cafetería, desarrollado en PHP y MySQL. Permite administrar cafés, clientes y visualizar ventas.

## Características

- Listado, creación, edición y eliminación de cafés.
- Gestión de clientes (alta, edición y baja).
- Visualización de ventas.
- Interfaz sencilla y responsive.
- Uso de MySQLi para la conexión a base de datos.

## Estructura del Proyecto

```
SRC/
  index.php
  bd/
    cafeteria.sql
  includes/
    barra-nav.php
    footer.php
    header.php
  model/
    basedatos.php
  public/
    css/
      index.css
    img/
    js/
  view/
    add-clientes.php
    clientes.php
    editar-cafe.php
    editar-cliente.php
    index.php
    nuevo-cafe.php
    retirar-cafe.php
README.md
```

## Instalación y Configuración

1. **Clona el repositorio** en tu servidor local (por ejemplo, XAMPP o WAMP):

   ```sh
   git clone https://github.com/tuusuario/dashboard-basico-cafes.git
   ```

2. **Importa la base de datos**:

   - Abre phpMyAdmin.
   - Crea una base de datos llamada `cafeteria_db`.
   - Importa el archivo [`SRC/bd/cafeteria.sql`](SRC/bd/cafeteria.sql).

3. **Configura la conexión a la base de datos**:

   - Edita [`SRC/model/basedatos.php`](SRC/model/basedatos.php) si tu usuario, contraseña o nombre de base de datos son diferentes.

4. **Accede a la aplicación**:

   - Ingresa a `http://localhost/SRC/index.php` desde tu navegador.

## Uso

- **Home:** Muestra el resumen de cafés, clientes y ventas.
- **Nuevo:** Permite agregar un nuevo café.
- **Retirados:** Permite editar o eliminar cafés existentes.
- **Clientes:** Permite gestionar los clientes.

## Créditos

Desarrollado por Angel Manuel Quintero — UDI Colombia.

---

![{21373495-4F9F-4B49-B2C5-D3D43874BFAA}](https://github.com/user-attachments/assets/764ef39a-e900-491e-b95d-91a2354383f3)
![{08CAB4C7-CF21-4E54-851F-674FD28679E9}](https://github.com/user-attachments/assets/74b1d986-c1e8-47f5-ba7c-50a00856a3b1)
![{A413133B-48E5-471F-9F90-7EAB67E44FF5}](https://github.com/user-attachments/assets/75013a7d-067c-4514-9ed7-34a0927ae1ce)
![{607FACA1-854C-47EB-94DE-E9FB41FF68C6}](https://github.com/user-attachments/assets/526965a3-d046-4921-88b3-cdfdd0a55550)
![{A3B891E2-E5AA-4BAA-8E42-C4E3C041DF2A}](https://github.com/user-attachments/assets/5f617f85-ef54-4f7a-ac6c-79df4b97c828)




