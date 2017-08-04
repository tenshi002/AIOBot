<?php
/**
 * Created by IntelliJ IDEA.
 * User: nico
 * Date: 18/07/17
 * Time: 17:21
 */

namespace lib\HTTP;


use Exception;
use lib\Application;
use lib\Constantes;
use lib\Twitch\TwitchApi;

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
     * @var string Le template de base de la page
     */
    protected $baseTemplate = '';

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

    protected $cssFiles = array();

    protected $jsFiles = array();

    protected $cache;


    /**
     * Encodage de la réponse
     *
     * @var string
     */
    protected $encoding = self::ENCODING_UTF8;

    /**
     * @var self
     */
    private static $instance;

    /**
     * @var Twig_Environment
     */
    private $twig;

    public static function getInstance($module = null, $controller = Constantes::BASE_CONTROLLER, $action = Constantes::BASE_ACTION)
    {
        if(is_null(self::$instance))
        {
            self::$instance = new HTTPResponse($module, $controller, $action);
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
        /* Tous les modules ont a disposition un fichier /public/css/nom_module/style.css ou /public/js/nom_module/scripts.js chargé automatiquement */
        if(file_exists(APPLICATION_PATH . '/public/css/' . $this->module . '.css'))
        {
            $this->addCSSFile($this->module . '.css');
        }
        if(file_exists(APPLICATION_PATH . '/public/js/' . $this->module . '.js'))
        {
            $this->addJSFile($this->module . '.js');
        }
        $twitchApi = TwitchApi::getInstance();
        $this->addTemplateVars(array(
            'twitchChannel' => Application::getInstance()->getTwitchChannel(),
            'twitchApi' => $twitchApi
        ));
        $this->setTitle($this->module);
    }

    public function setTitle($title)
    {
        if(!is_string($title))
        {
            throw new Exception('Le titre doit être une chaine de caractères !');
        }
        $this->addTemplateVar('title', 'AIOBot - Best Twitch bot WORLD (> °o°)> <(°u° <) - ' . $title);
    }

    private function setDefaultTemplate()
    {
        $this->template = '/' . $this->module . '/' . $this->action . '.twig';
    }

    private function setDefaultBaseTemplate()
    {
        $this->baseTemplate = 'standard.twig';
        $this->addTemplateVar('baseTemplate', $this->baseTemplate);
    }

    public function sendResponse()
    {
        $this->compileVars();
        if(empty($this->baseTemplate) && $this->contentType === self::CONTENT_TYPE_DEFAULT)
        {
            $this->setDefaultBaseTemplate();
        }
        if(empty($this->template) && $this->contentType === self::CONTENT_TYPE_DEFAULT)
        {
            $this->setDefaultTemplate();
        }

        switch($this->contentType)
        {
            case self::CONTENT_TYPE_DEFAULT:
                $this->displayTemplate();
                break;
            case self::CONTENT_TYPE_JSON:
                $this->displayJSON();
                exit(0);
                break;
            case self::CONTENT_TYPE_FORCE_DOWNLOAD:
                $this->displayDownload();
                exit(0);
                break;
            case self::CONTENT_TYPE_REDIRECT:
                $this->redirect();
                break;
        }
    }

    public function getRenderedTemplate()
    {
        return $this->getTwig()->render($this->template, $this->templatesVars);
    }

    private function displayTemplate()
    {
        $template = $this->getTwig()->load($this->template);
        $template->display($this->templatesVars);
    }

    private function displayJSON()
    {
        header('Content-type: application/json');
        $this->headerNoCache();
        $varList = $this->content;
        $json = json_encode($varList);
        /* Compatibilité Chrome avec Json version fat */
        header('Content-Length: ' . strlen($json));
        echo $json;
    }

    private function displayDownload()
    {
        if(!empty($this->MimeType))
        {
            header('Content-type: ' . $this->MimeType);
        }
        else
        {
            header('Content-type: application/octet-stream');
        }
        header('Content-Transfer-Encoding: binary');
        if($this->FileName !== null)
        {
            header('Content-Disposition: attachment; filename="' . $this->FileName . '"');
        }
        $this->headerNoCache();
        if(isset($this->FilePath))
        {
            if($this->FileName === null)
            {
                header('Content-Disposition: attachment; filename="' . basename($this->FilePath) . '"');
            }
            header('Content-Length: ' . filesize($this->FilePath));
            // dump du contenu du fichier
            readfile($this->FilePath);
        }
        else
        {
            echo $this->content;
        }
    }

    private function redirect()
    {
        header('Location: ' . $this->content);
    }

    private function headerNoCache()
    {
        header('Cache-Control: no-cache, must-revalidate');
        header('Expires: Sat, 26 Jul 1997 05:00:00 GMT');
    }

    private function getTwig()
    {

        if(is_null($this->twig))
        {
            if(Application::getInstance()->getConfigurateur('html.cache') == 0)
            {
                $this->cache = false;
            }
            else
            {
                $this->cache = true;
            }
            $loader = new \Twig_Loader_Filesystem(array(
                Application::getInstance()->getApplicationBasePath() . '/scripts/views',
                Application::getInstance()->getApplicationBasePath() . '/scripts/views/' . $this->module,
                Application::getInstance()->getApplicationBasePath() . '/public/templates',
                Application::getInstance()->getApplicationBasePath() . '/public/templates/common'
            ));
            if($this->cache)
            {
                $this->twig = new \Twig_Environment($loader, array('cache' => Application::getInstance()->getApplicationBasePath() . '/cache'));
            }
            else
            {
                $this->twig = new \Twig_Environment($loader);
            }

        }
        return $this->twig;
    }

    /**
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * @param string $content
     */
    public function setContent($content)
    {
        $this->content = $content;
    }

    /**
     * @param string $template
     */
    public function setTemplate($template)
    {
        $this->template = $template;
    }

    /**
     * @param string $baseTemplate
     */
    public function setBaseTemplate($baseTemplate)
    {
        $this->baseTemplate = $baseTemplate;
    }

    /**
     * @return array
     */
    public function getTemplatesVars()
    {
        return $this->templatesVars;
    }

    public function getTemplatesVar($key)
    {
        if(isset($this->templatesVars[$key]))
        {
            return $this->templatesVars[$key];
        }
        return null;
    }

    public function addTemplateVar($name, $value)
    {
        $this->templatesVars[$name] = $value;
    }

    public function addTemplateVars(array $array)
    {
        foreach($array as $key => $value)
        {
            $this->addTemplateVar($key, $value);
        }
    }

    public function addJSFile($jsfile)
    {
        $this->jsFiles[] = $jsfile;
    }

    public function addJSFiles($jsFiles)
    {
        foreach($jsFiles as $jsFile)
        {
            $this->addJSFile($jsFile);
        }
    }

    public function addCSSFile($cssfile)
    {
        $this->cssFiles[] = $cssfile;
    }

    public function addCSSFiles($cssFiles)
    {
        foreach($cssFiles as $cssFile)
        {
            $this->addCSSFile($cssFile);
        }
    }

    private function compileVars()
    {
        $this->templatesVars['css_files'] = $this->cssFiles;
        $this->templatesVars['js_files'] = $this->jsFiles;
    }

    /**
     * @param string $contentType
     */
    public function setContentType($contentType)
    {
        $this->contentType = $contentType;
    }

    public function setJSONFlashMessageContent($title, $message, $type = 'info')
    {
        $this->content = array(
            'title' => $title,
            'message' => $message,
            'type' => $type
        );
    }


}