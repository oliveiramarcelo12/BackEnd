<?php
// endereco
// nome do BD
// usuario
// senha
$endereco = 'localhost';
$banco = 'marcelo';
$admin = 'postgres';
$senha = 'postgres';
try {
// sgbd:host;port;dbname
// admin
// senha
// errmode
$pdo = new PDO("pgsql:host=$endereco;port=5432;dbname=$banco", $admin, $senha,
[PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
echo "Conectado no banco de dados!!!";
$sql = "CREATE TABLE IF NOT EXISTS usuario (ID SERIAL,
    nome VARCHAR(100) NOT NULL,
    data_nascimento DATE NOT NULL,
    telefone VARCHAR(20) NOT NULL,
    email VARCHAR(100) Primary Key NOT NULL,
    senha VARCHAR(255) NOT NULL
)";
$stmt = $pdo->prepare($sql);
// Executar a consulta SQL
$pdo->exec($sql);


} catch (PDOException $e) {
echo "Falha ao conectar ao banco de dados. <br/>";
die($e->getMessage());
}
?>