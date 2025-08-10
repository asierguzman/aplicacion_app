Esta es una aplicación web para manejar tus contactos, creada con PHP y MySQL. 
Con ella puedes registrarte, entrar a tu cuenta y hacer todas las cosas básicas con tus contactos, como crearlos, verlos, editarlos y borrarlos.

Para que la aplicación funcione, necesitas tener un servidor web instalado, como google o firefox, aunque el servidor que viene con PHP también sirve. 
También necesitas PHP, de la versión 7.4 en adelante, porque usamos cosas de código más recientes y una forma segura de conectar a la base de datos llamada PDO. 
Y claro, necesitas un servidor de base de datos MySQL, para lo cual MySQL Workbench es una herramienta muy recomendable.

Lo primero que tienes que hacer para empezar es configurar la base de datos. 
Debes abrir MySQL Workbench y conectarte a tu servidor. 
Luego, creas una nueva ventana de consultas, copias y pegas todo el código que está en el archivo contactos_app.sql y lo ejecutas. 
Esto va a crear una base de datos llamada contactos_app y dentro de ella las dos tablas que necesitas, usuarios y contactos, 
con todas sus configuraciones para que funcionen juntas correctamente.

Después de eso, para iniciar el servidor de la aplicación, solo tienes que abrir la terminal o la línea de comandos, 
ir a la carpeta donde tienes guardados los archivos y escribir php -S localhost:8000. Puedes cambiar 8000 por el número de puerto que prefieras. 
Con eso listo, abres tu navegador y escribes http://localhost:8000/login.php para empezar a usarla.

Cada archivo de la aplicación tiene una tarea específica. El archivo login.php es la página de inicio, donde pones tu correo y contraseña para entrar. 
Si todo está bien, te lleva a la página penal_usuario.php. Si no tienes cuenta, puedes ir a registro_form.php para crear una. El archivo registro_process.php 
se encarga de guardar tu información de registro en la base de datos, revisando que tu correo no exista ya.

El panel_usuario.php es tu panel principal. Ahí puedes ver todos los contactos que tienes guardados y desde ahí puedes editarlos o eliminarlos. 
Para añadir un contacto nuevo, vas a contacto_add.php que tiene el formulario para que pongas sus datos. El archivo contacto_edit.php te permite cambiar la información 
de un contacto que ya tienes. Para salir de la cuenta, solo tienes que ir a logout.php, que borra tu sesión. 
También hay un archivo llamado reorganizar_ids.php que sirve para poner en orden los números de identificación (IDs) de los usuarios y contactos, 
si por alguna razón se desordenaron.

Por último, pero muy importante, el archivo includes/database.php es el que contiene la información para que la aplicación se conecte de forma segura a la base de datos,
 con todos los datos como el servidor, el nombre de la base de datos, el usuario y la contraseña.
