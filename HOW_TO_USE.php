// On commence par inclure la classe nous permettant d'enregistrer nos autoload
require('./lib/DFram/SplClassLoader.php');

// On va ensuite enregistrer les autoloads correspondant à chaque vendor (DFram, App, Model, etc.)
$NAMESPACEloader = new SplClassLoader('NAMESPACE', __DIR__ . 'CHEMIN_DOSSIER');
$NAMESPACEloader->register();