# Proyecto TFG – Simulación de Tienda Online

## 📌 Descripción general
Este proyecto forma parte del **Trabajo de Fin de Grado (TFG)** y consiste en el desarrollo de una **aplicación web que simula una tienda online**. El objetivo principal es recrear un entorno realista de comercio electrónico, incluyendo funcionalidades típicas tanto a nivel de usuario como de infraestructura.

La aplicación está diseñada para desplegarse en un **entorno contenerizado mediante Docker Compose**, lo que facilita su despliegue, portabilidad y replicación en distintos sistemas.

---

## 🏗️ Arquitectura y estructura del proyecto
El proyecto se basa en una arquitectura modular levantada mediante **Docker Compose**, donde cada servicio se ejecuta en su propio contenedor. La organización lógica del sistema es la siguiente:

- **Aplicación web**: Servicio principal que contiene la lógica de la tienda online.
- **Base de datos**: Servicio encargado del almacenamiento persistente de la información.
- **Servidor web**: Gestiona las peticiones HTTP y sirve la aplicación al cliente.

---

## 🎯 Propósito del proyecto
El propósito de esta web es:

- Simular el funcionamiento de una **tienda online real**.
- Aplicar conocimientos de **desarrollo web en entorno servidor**, **despliegue de aplicaciones web** y **desarrollo web en entorno cliente**.

---

## ⚙️ Funcionalidades implementadas
A continuación se detallan las principales funcionalidades desarrolladas hasta el momento:

### 👤 Gestión de usuarios
- Registro de nuevos usuarios.
- Inicio de sesión.

### 🛍️ Tienda online
- Visualización del catálogo de productos (En proceso).

### 🔐 Seguridad básica
- Validación de entradas de usuario.
- Protección frente a inyección de código HTML/JavaScript.
- Separación de servicios mediante contenedores.

### 🐳 Infraestructura
- Despliegue completo mediante **Docker Compose**.
- Configuración automática de servicios y red interna.
- Facilidad para levantar y detener el entorno.

---

## 🚀 Puesta en marcha del proyecto

### Requisitos previos
Antes de ejecutar el proyecto es necesario tener instalado:

- **Docker**
- **Docker Compose**

### ▶️ Levantar la aplicación
Desde el directorio raíz del proyecto, ejecutar:

```bash
docker compose up --build -d
```

Este comando:
- Construye las imágenes necesarias (si no existen).
- Levanta todos los servicios definidos.
- Ejecuta la aplicación en segundo plano.

### ⏹️ Detener la aplicación
Para detener y eliminar los contenedores:

```bash
docker compose down
```

---

## 🧪 Estado del proyecto
El proyecto se encuentra en **fase de desarrollo**, con algunas de las funcionalidades principales ya implementadas y preparado para futuras ampliaciones, mejoras de seguridad y optimización del código.

---

## 📚 Contexto académico
Este proyecto ha sido desarrollado exclusivamente con fines **académicos**, como parte del **Trabajo de Fin de Grado**, y su finalidad es demostrar la aplicación práctica de los conocimientos adquiridos durante la formación.

---

## ✍️ Autores
Proyecto desarrollado por los siguientes estudiantes:

- José Luis Ramírez Barrios
- Ángeles Alexandra Angamarca Bonete
- David Ávila Sánchez 