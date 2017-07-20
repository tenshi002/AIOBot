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
     * Type de réponse SMARTY
     */
    const CONTENT_TYPE_DEFAULT = 'TWIG';

    /**
     * Type de réponse JSON
     */
    const CONTENT_TYPE_JSON = 'JSON';

    /**
     * Redirect
     */
    const CONTENT_TYPE_REDIRECT = 'REDIRECT';

    /**
     * Pour forcer le navigateu à télécharger le fichier au lieu de l'afficher
     */
    const CONTENT_TYPE_FORCE_DOWNLOAD = 'FORCE-DOWNLOAD';

    /**
     * Encodage UTF8
     */
    const ENCODING_UTF8 = 'UTF8';

    /**
     * @var string Type de la réponse
     */
    protected $contentType;

    /**
     * @var string Contenu de la réponse. Peut être vide, par exemple dans le cas d'utilisation de smarty
     */
    protected $content = '';

    /**
     * @var string Le module appellé
     */
    protected $module;

    /**
     * @var string L'action du module appellé
     */
    protected $action;

    /**
     * @var string Le controleur du module appellé
     */
    protected $controller;

    /**
     * @var string Le template appellé dans le cas d'une réponse de type TWIG
     */
    protected $template = '';

    /**
     * Le mime type à envoyer avec le fichier
     *
     * @var string
     */
    protected $MimeType;

    /**
     * Le chemin du fichier à envoyer
     *
     * @var string
     */
    protected $FilePath;

    /**
     * Le nom du fichier à envoyer lors d'un téléchargement
     * Correspond, par défaut, au nom du fichier spécifié par FilePath
     *
     * @var string
     */
    protected $FileName;

    /**
     * @var array Les variables passées au template Smarty
     */
    protected $templatesVars = array();

    /**
     * Encodage de la réponse
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