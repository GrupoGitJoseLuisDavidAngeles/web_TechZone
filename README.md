# TechZone 🛒

TechZone es una tienda online de productos tecnológicos desarrollada con PHP, MySQL, JavaScript y CSS vanilla. El proyecto incluye gestión de productos, carritos de compra, sistema de autenticación con JWT y un panel de administración completo.

## 📋 Características

### Para Clientes
- **Catálogo de productos** con categorías (Portátiles, Sobremesa, Componentes, Periféricos)
- **Sistema de búsqueda** por nombre y categoría
- **Carrito de compra** persistente
- **Sistema de ofertas** con precios especiales
- **Gestión y listado de pedidos**
- **Perfil de usuario**
- **Autenticación segura** con JWT

### Para Administradores
- **Panel de administración** para gestión de productos
- **CRUD completo** de productos (Crear, Leer, Actualizar, Eliminar)
- **Gestión de stock** e inventario
- **Asignación de categorías** a productos

## 🛠️ Tecnologías Utilizadas

### Backend
- PHP 8.2
- MySQL
- PDO para conexión a base de datos
- JWT para autenticación

### Frontend
- HTML5
- CSS3
- JavaScript
- Fetch API para comunicación con el servidor

### Infraestructura
- Docker & Docker Compose
- Apache Web Server

## 📁 Estructura del Proyecto

```
tfg/
├── Docker/
│   ├── database/
│   │   └── init.sql          # Script de inicialización de BD
│   ├── web/
│   │   └── Dockerfile        # Imagen PHP-Apache
│   └── docker-compose.yml    # Orquestación de contenedores
│
├── src/
│   ├── admin/               # Panel de administración
│   ├── api/                 # Endpoints de la API REST
│   ├── assets/              # Imágenes y recursos estáticos
│   ├── auth/                # Login y registro
│   ├── cart/                # Carrito de compra
│   ├── config/              # Configuración de BD
│   ├── libs/                # Utilidades (JWT, búsqueda)
│   ├── products/            # Páginas de productos
│   ├── profile/             # Perfil de usuario
│   ├── public/              # Página principal
│   ├── search/              # Página de búsqueda
│   └── services/            # Servicios JavaScript (API clients)
```

## 🚀 Instalación y Uso

### Requisitos Previos
- Docker
- Docker Compose

### Pasos de Instalación

1. **Clonar el repositorio**
```bash
git clone <url-del-repositorio>
cd <carpeta-clonada>
```

2. **Levantar los contenedores**
```bash
cd Docker
docker-compose up --build -d
```

> **Nota:** El flag `--build` es necesario la primera vez para construir la imagen personalizada de PHP con las extensiones necesarias. En ejecuciones posteriores puedes usar solo `docker-compose up -d`.

3. **Acceder a la aplicación**
- Web: http://localhost:8081
- Base de datos: localhost:45000

### Usuarios Predeterminados

**Administrador:**
- Email: `admin@techzone.com`
- Contraseña: `admin`

## 🗄️ Base de Datos

### Tablas Principales

- **usuarios**: Información de usuarios y roles
- **categorias**: Categorías de productos
- **productos**: Catálogo de productos
- **carritos** y **carrito_productos**: Sistema de carrito de compra
- **ofertas**: Productos en oferta con precios especiales
- **pedidos** y **pedido_productos**: Gestión de pedidos

## 🔌 API Endpoints

### Productos
- `GET /api/productos.php` - Obtener todos los productos
- `GET /api/productos.php?id={id}` - Obtener producto por ID
- `POST /api/productos_save.php` - Crear/actualizar producto (requiere auth)
- `POST /api/productos_delete.php` - Eliminar producto (requiere auth)
- `GET /api/productos_search.php?name={name}&category={category}` - Buscar productos

### Categorías
- `GET /api/categorias.php` - Obtener todas las categorías
- `GET /api/categoria.php?id={id}` - Obtener categoría por ID

### Ofertas
- `GET /api/ofertas.php` - Obtener productos en oferta

### Autenticación
- `POST /api/login.php` - Iniciar sesión
- `GET /api/usuario.php` - Obtener datos del usuario (requiere auth)

### Carrito
- `GET /api/carrito_get.php` - Obtener carrito del usuario
- `POST /api/carrito_add.php` - Añadir producto al carrito
- `POST /api/carrito_delete.php` - Eliminar producto del carrito
- `POST /api/carrito_clear.php` - Vaciar carrito

### Pedidos
- `GET /api/pedidos_get.php` - Obtener pedidos del usuario
- `POST /api/pedido_add.php` - Crear nuevo pedido

## 🔐 Autenticación

El sistema utiliza JSON Web Tokens (JWT) para la autenticación. Los tokens se almacenan en localStorage y se envían en el header `Authorization: Bearer {token}` en las peticiones que requieren autenticación.

### Roles
- **admin**: Acceso completo al panel de administración
- **cliente**: Acceso a funcionalidades de compra

## 🎨 Características del Frontend

- Diseño responsive
- Carrusel de productos destacados
- Búsqueda en tiempo real
- Filtrado por categorías
- Interfaz intuitiva y moderna

## 📦 Datos de Prueba

La base de datos incluye datos de prueba con:
- 4 categorías de productos
- 15 productos de ejemplo
- 8 ofertas activas
- 1 usuario administrador

## 🔧 Configuración

### Configuración de Base de Datos
Ubicación: `src/config/Database.php`

```php
$host = 'mysql';
$db   = 'tienda_online';
$user = 'admin';
$pass = 'admin';
```

### Puertos
- Aplicación web: `8081`
- MySQL: `45000`

## 🐳 Docker Compose

Los servicios incluidos son:

- **mysql**: Base de datos MySQL 8.0
- **web**: Servidor Apache con PHP 8.2

```yaml
services:
  mysql:
    image: mysql:8.0
    ports:
      - "45000:3306"
    environment:
      MYSQL_DATABASE: tienda_online
      MYSQL_USER: admin
      MYSQL_PASSWORD: admin

  web:
    build: ./web
    ports:
      - "8081:80"
    depends_on:
      - mysql
```

## 📄 Licencia

Este proyecto es un Trabajo de Fin de Grado (TFG) con fines puramente académicos.

## ✍️ Autores
Proyecto desarrollado por los siguientes estudiantes:

- José Luis Ramírez Barrios
- Ángeles Alexandra Angamarca Bonete
- David Ávila Sánchez 
