# API para Consulta de Padrón Electoral

 Esta API permite realizar consultas de ciudadanos costarricenses utilizando una base de datos local de MongoDB cargada con los datos del Tribunal Supremo de Elecciones (TSE).

## Requerimientos:
  - Webserver: Servidor integrado de PHP (php -S localhost:8000)  
  - PHP 8.2 (usado de XAMPP o instalado directamente)
  - MongoDB (extensión MongoDB para PHP)
  - Composer (para instalar dependencias)


<br><br>
## Configuración del Entorno PHP


### 🔹 Habilitar extensión MongoDB

#### 1- Descargar el driver de MongoDB
Descargarlo desde PECL (PHP 8.2 Thread Safe x64): https://pecl.php.net/package/mongodb/2.2.1/windows

#### 2 - Instalar el driver

Copiar el archivo .dll en C:\xampp\php\ext.

#### 3- Configurar PHP

Abrir archivo php.ini en:

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



<br><br>
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

Si no cuenta con mongoexport, puede descargar la herramienta de MongoDB, en la sección de "MongoDB Command Line Database Tools Download"

https://www.mongodb.com/try/download/database-tools



```bash
mongoimport --db padron --collection personas --type csv -f CEDULA,CODELEC,SEXO,FECHACADUC,JUNTA,NOMBRE,PAPELLIDO,SAPELLIDO --file PADRON_COMPLETO.txt
```

### 🔹 Crear índice

#### 1- Abrir MongoDB Shell y ejecutar
```bash
mongo
```

#### 2- Seleccionar la base de datos y crear el indice

```bash
use padron;
db.personas.createIndex({ "CEDULA": 1 });
```

### 🔹 Verificar datos

```bash
db.personas.findOne({ CEDULA: 101240037 });
```




<br><br>
## Instalación de dependencias

Dentro de la carpeta raíz del proyecto ejecutar:

```bash
composer require mongodb/mongodb
```


<br><br>
## Ejecutar el Proyecto

Inicia el servidor local de PHP con el siguiente comando:

```bash
php -S localhost:8000
```


<br><br>
## Ejemplo de uso

Puedes consultar una cédula desde el navegador o herramientas como Postman:

```bash
http://localhost:8000/cedula/101240037
```


<br><br>
## Software
 El proyecto utiliza el servidor integrado de PHP (`php -S localhost:8000`), sin necesidad de configuración adicional.

