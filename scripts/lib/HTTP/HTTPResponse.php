<?php
/**
 * Created by IntelliJ IDEA.
 * User: nico
 * Date: 18/07/17
 * Time: 17:21
 */

namespace lib\HTTP;


use Exception;
use lib\Constantes;

class HTTPResponse
{
    /**
     * Type de r�ponse SMARTY
     */
    const CONTENT_TYPE_DEFAULT = 'TWIG';

    /**
     * Type de r�ponse JSON
     */
    const CONTENT_TYPE_JSON = 'JSON';

    /**
     * Redirect
     */
    const CONTENT_TYPE_REDIRECT = 'REDIRECT';

    /**
     * Pour forcer le navigateu � t�l�charger le fichier au lieu de l'afficher
     */
    const CONTENT_TYPE_FORCE_DOWNLOAD = 'FORCE-DOWNLOAD';

    /**
     * Encodage UTF8
     */
    const ENCODING_UTF8 = 'UTF8';

    /**
     * @var string Type de la r�ponse
     */
    protected $contentType;

    /**
     * @var string Contenu de la r�ponse. Peut �tre vide, par exemple dans le cas d'utilisation de smarty
     */
    protected $content = '';

    /**
     * @var string Le module appell�
     */
    protected $module;

    /**
     * @var string L'action du module appell�
     */
    protected $action;

    /**
     * @var string Le controleur du module appell�
     */
    protected $controller;

    /**
     * @var string Le template appell� dans le cas d'une r�ponse de type TWIG
     */
    protected $template = '';

    /**
     * Le mime type � envoyer avec le fichier
     *
     * @var string
     */
    protected $MimeType;

    /**
     * Le chemin du fichier � envoyer
     *
     * @var string
     */
    protected $FilePath;

    /**
     * Le nom du fichier � envoyer lors d'un t�l�chargement
     * Correspond, par d�faut, au nom du fichier sp�cifi� par FilePath
     *
     * @var string
     */
    protected $FileName;

    /**
     * @var array Les variables pass�es au template Smarty
     */
    protected $templatesVars = array();

    /**
     * Encodage de la r�ponse
     *
     * @var string
     */
    protected $encoding = self::ENCODING_UTF8;

    private static $instance;

    private $twig;

    public static function getInstance($module = null, $controller = Constantes::BASE_CONTROLLER, $action = Constantes::BASE_ACTION)
    {
        if(is_null(self::$instance))
        {
            self::$instance = new HTTPResponse($module,$controller,$action);
        }
        return self::$instance;
    }

    /**
     * Construit un objet de type WebResponse
     *
     * @param null $module
     * @param string $controller
     * @param string $action
     */
    private function __construct($module = null, $controller = Constantes::BASE_CONTROLLER, $action = Constantes::BASE_ACTION)
    {
        $this->module = $module;
        $this->controller = $controller;
        $this->action = $action;
        $this->contentType = self::CONTENT_TYPE_DEFAULT;
    }

    private function initTwig()
    {

    }
}