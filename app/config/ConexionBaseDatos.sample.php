<?php
declare(strict_types=1);

// Definición del espacio de trabajo. 
namespace App\Config;

// Importación de clases. 
use PDO;
use PDOException;

// Clase responsable de establecer y administrar la conexión con MySQL.
class ConexionBaseDatos
{
    // Son incluidos los atributos respectivos a la conexión. Así como a la base de datos. 
    // Las variables se dejan en blanco para evitar el filtrado de información. 
    // Llenar los campos al momento de realizar la prueba de conexión. 
    private string $host = "";
    private string $user = "";
    private string $password = "";
    private string $db = "";
    private int $port = 0;
    private ?PDO $conect = null;

    // La función constructor se llama cuando se quiere hacer una conexión y se pasan los atributos correspondientes a la conexión y a la base de datos donde se va a conectar. 
    public function __construct()
    {
        // Este objeto recibe la conexión con los datos correspondientes. 
        $connectionString = "mysql:host={$this->host};port={$this->port};dbname={$this->db};charset=utf8mb4";
        // Un try-catch para asegurar la conexión. 
        try {
            // Se genera el nuevo objeto y se pasa a el objeto tipo conexión. 
            $this->conect = new PDO($connectionString, $this->user, $this->password);
            // Configurar manejo de errores mediante excepciones De manera que estos atributos de la excepción y sus descripciones se anexen al objeto que se creó. 
            $this->conect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            // Configurar modo de obtención por defecto como array asociativo
            $this->conect->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            // Se cierra la conexión y los atributos se eliminan. 
            $this->conect = null;    
            // Se muestra el mensaje obtenido del error de la conexión.         
            echo "Error de conexión: " . $e->getMessage();
        }
    }

    // La función conecta retorna el objeto con las propiedades de la conexión a la base de datos. 
    public function conectar()
    {
        return $this->conect;
    }

    // Función para desconectar de la base de datos. 
    public function desconectar(): void
    {
        $this->conect = null;
    }
}



// Prueba de conexión. 
// Instancia el objeto ConexionBaseDatos. 
$conexion = new ConexionBaseDatos();
// Llama al método "connect". 
$db = $conexion->conectar();
echo "<br>";
// Si la conexión es exitosa, muestra un mensaje. 
if ($db) {
    echo "Conexión exitosa";
} else {
    echo "Fallo en la conexión. ";
}

