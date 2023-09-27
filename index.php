<?php
// Connexion à la base de données
$host = "localhost";
$db = "tp_1";
$user = "root";
$password = "";
$dsn = "mysql:host=$host;dbname=$db;charset=UTF8";
global $oPDO;
try {
    $oPDO = new PDO($dsn, $user, $password);
    if ($oPDO) {
        echo "Connected to the $db database successfully!";
    }
} catch (PDOException $e) {
    echo $e->getMessage();
}

require_once "class/camera.php";
$oCamera = new Camera();
echo"</br>";
echo"Affichage de tous les elemets";
echo "</br>";
var_dump($oCamera);
$cameras = $oCamera->getCameras();
echo "</br>";
echo "</br>";
print_r($cameras);
echo "</br>";

// Afficher avec l'id
echo "_______________________";
echo "</br>";
echo"Afficahe d'un seul";
echo "</br>";
$camera = $oCamera->getCamera("2");
var_dump($camera);
echo "</br>";
echo "</br>";
echo "_______________________";
echo "</br>";
echo"Ajout";
echo "</br>";

// Pour ajouter une nouvelle caméra
$new_camera = [
    'brand' => "Panasonic", 
    'storage' => "256GB", 
    'price' => 2000.00 
];

$camera_Added = $oCamera->addCamera($new_camera);
echo "</br>";
echo "</br>";
var_dump($oCamera->getCameras());


// Pour modifier
echo "</br>";
echo "</br>";
echo "_______________________";
echo "</br>";
echo"Modification";
echo "</br>";
$oCamera = new Camera();
$camera = $oCamera->getCamera(1);
echo "<br>";
echo "<br>";
$camera['brand'] = "Fujifilm"; 
$camera['price'] = 1246.77; 
$oCamera->updateCameraById($camera['id'], $camera);
var_dump($oCamera->getCamera(1));
echo "</br>";
echo "</br>";
echo "_______________________";
echo "</br>";
echo "</br>";

// Pour supprimer

var_dump($oCamera->deleteCamera(2));
echo "</br>";
echo"supprimer";
echo "</br>";
echo "_______________________";
echo "</br>";
echo"affichage du trie";
echo "</br>";

//pour afficher le trie
// Appel de la méthode getCamerasByStockage depuis l'objet $oCamera
$cameras = $oCamera->getCamerasByStockage("256GB");

// Affichage du résultat
var_dump($cameras);
?>
