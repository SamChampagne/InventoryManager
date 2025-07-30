/** Déclaration des services pour chaque page que j'utilise */ 
require_once '../config/dbConfig.php';
include_once '../services/createUser-transaction.php';
include_once '../services/getAllUser-transaction.php';
include_once '../services/getAllWarehouses-transaction.php';
include_once '../services/createWarehouses-transaction.php';
include_once '../services/getAllProduct-transaction.php';
include_once '../services/createProduct-transaction.php';
include_once '../services/assignUserToWarehouses-transaction.php';
include_once '../services/listeInventoryToUser-transaction.php';
include_once '../services/createProductInInventory-transaction.php';