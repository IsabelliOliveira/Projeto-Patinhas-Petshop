<?php
// Classe para lidar com a conexão com o banco de dados
class DBConnection {
    private $host = "localhost";
    private $database = "patinhas"; // Substitua pelo nome do seu banco de dados
    private $username = "root";
    private $password = ""; // Substitua pela senha do seu banco de dados
    public $conn;

    // Método para conectar ao banco de dados MySQL usando PDO
    public function __construct() {
        try {
            $this->conn = new PDO("mysql:host={$this->host};dbname={$this->database}", $this->username, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch(PDOException $e) {
            echo "Erro na conexão: " . $e->getMessage();
        }
        return $this->conn;
    }

    // Método para retornar a conexão com o banco de dados
    public function getConnection() {
        return $this->conn;
    }
}
?>


