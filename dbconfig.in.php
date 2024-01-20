<?php 
define('DBHOST', 'localhost');
define('DBNAME', 'web1171174_db');
define('DBUSER', 'web1171174_dbuser');
define('DBPASS', '@5E3Y!_s5Y');
define('DBCONNSTRING', "mysql:host=".DBHOST.";dbname=".DBNAME.";charset=utf8mb4");
ini_set('display_errors', 1);
error_reporting(E_ALL);

try {
    $pdo = new PDO(DBCONNSTRING, DBUSER, DBPASS);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
    exit;
}
?>
