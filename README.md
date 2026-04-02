# API para Consulta de Padrón Electoral

 > Esta API permite realizar consultas de ciudadanos costarricenses utilizando una base de datos local de MongoDB cargada con los datos del Tribunal Supremo de Elecciones (TSE).

## Requerimientos:
- **Webserver:** Servidor integrado de PHP (php -S localhost:8000)  


- **API:**
  - PHP 8.2 (Thread Safe)
  - Extensión MongoDB (`mongodb` - PECL)

- **Base de Datos:**
  - MongoDB

- **Dependencias:**
  - Composer

## Base de Datos
Este proyecto utiliza el archivo oficial del padrón electoral en formato `.txt`.

### 🔹 Descargar padrón

Descargar desde el sitio oficial del TSE:

http://www.tse.go.cr/zip/padron/padron_completo.zip

Descomprimir:

```bash
unzip padron_completo.zip
```

### 🔹 Importar datos a MongoDB

```bash
mongoimport --db padron --collection personas --type csv -f CEDULA,CODELEC,SEXO,FECHACADUC,JUNTA,NOMBRE,PAPELLIDO,SAPELLIDO --file PADRON_COMPLETO.txt
```

### 🔹 Crear índice

```bash
use padron;
db.personas.createIndex({ "CEDULA": 1 });
```

### 🔹 Verificar datos

```bash
db.personas.findOne({ CEDULA: 101240037 });
```


## Configuración del Entorno PHP


### 🔹 Habilitar extensión MongoDB

Descargar el driver desde PECL (PHP 8.2 Thread Safe x64)

https://pecl.php.net/package/mongodb/2.2.1/windows

Copiar el archivo .dll en C:\xampp\php\ext:

Abrir archivo:

```bash
code C:\xampp\php\php.ini
```

Editar el archivo php.ini y agregar en Dynamic Dependency:

```bash
extension=mongodb
```

### 🔹 Verificar instalación

```bash
php -m | findstr mongodb
```


## Instalación de dependencias

Dentro de la carpeta raíz del proyecto ejecutar:

```bash
composer require mongodb/mongodb
```

## Ejecutar el Proyecto

Levanta el servidor local:

```bash
php -S localhost:8000
```


## Ejemplo de uso

Puedes consultar una cédula desde el navegador o herramientas como Postman:

```bash
http://localhost:8000/cedula/101240037
```


## Software
 El proyecto utiliza el servidor integrado de PHP (`php -S localhost:8000`), sin necesidad de configuración adicional.

