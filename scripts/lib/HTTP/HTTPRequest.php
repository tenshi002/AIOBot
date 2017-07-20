<?php
/**
 * Created by IntelliJ IDEA.
 * User: nico
 * Date: 18/07/17
 * Time: 17:21
 */

namespace lib\HTTP;


use Exception;

class HTTPRequest
{
    const GET = 'GET';
    const POST = 'POST';
    const PUT = 'PUT';
    const DELETE = 'DELETE';
    const HEAD = 'HEAD';

    protected $getParameters = null;
    protected $postParameters = null;
    protected $fileParameters = null;
    protected $cookieParameters = null;
    protected $serverParameters = null;
    protected $requestParameters = null;
    /**
     * @var ParameterHolder|null
     */
    protected $parameterHolder = null;
    /**
     * @var ParameterHolder|null
     */
    protected $attributeHolder = null;
    protected $method = null;

    private static $instance;

    private function __construct($parameters = array(), $attributes = array())
    {
        // initialize parameter and attribute holders
        $this->parameterHolder = new ParameterHolder();
        $this->attributeHolder = new ParameterHolder();

        $this->parameterHolder->add($parameters);
        $this->attributeHolder->add($attributes);

        $this->setHTTPParameters();
        $this->serverParameters = $_SERVER;

        $this->parameterHolder->add($this->getParameters);
        $this->parameterHolder->add($this->postParameters);
        $this->parameterHolder->add($this->cookieParameters);
        $this->parameterHolder->add($this->fileParameters);

        if(isset($_SERVER['REQUEST_METHOD']))
        {
            switch($_SERVER['REQUEST_METHOD'])
            {
                case self::GET:
                    $this->setMethod(self::GET);
                    break;
                case self::POST:
                    $this->setMethod(self::POST);
                    break;
                default:
                    $this->setMethod(self::GET);
            }
        }
        else
        {
            // set the default method
            $this->setMethod(self::GET);
        }
    }

    public static function getInstance($parameters = array(), $attributes = array())
    {
        if(is_null(self::$instance))
        {
            self::$instance = new HTTPRequest($parameters, $attributes);
        }
        return self::$instance;
    }

    private function setHTTPParameters()
    {
        $this->getParameters = $_GET;
        $this->postParameters = $_POST;
        $this->cookieParameters = $_COOKIE;
        $this->fileParameters = $_FILES;
    }

    /**
     * Détermine si la requête est un appel Ajax
     *
     * @return boolean TRUE si appel Ajax
     */
    public function isXMLHTTPRequest()
    {
        return array_key_exists('HTTP_X_REQUESTED_WITH', $_SERVER) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';
    }

    /**
     * @param string $method
     * @throws Exception
     */
    public function setMethod($method)
    {
        if(!in_array(strtoupper($method), array(self::GET, self::POST, self::PUT, self::DELETE, self::HEAD)))
        {
            throw new Exception(sprintf('Invalid request method: %s.', $method));
        }

        $this->method = $method;
    }

    /**
     * Returns the value of a GET parameter.
     *
     * @param  string $name The GET parameter name
     * @param  string $default The default value
     * @return string The GET parameter value
     */
    public function getGetParameter($name, $default = null)
    {
        if(isset($this->getParameters[$name]))
        {
            $value = $this->getParameters[$name];
            return $value;
        }
        return $default;
    }

    /**
     * Returns the value of a POST parameter.
     *
     * @param  string $name The POST parameter name
     * @param  string $default The default value
     * @return string The POST parameter value
     */
    public function getPostParameter($name, $default = null)
    {
        if(isset($this->postParameters[$name]))
        {
            $value = $this->postParameters[$name];
            return $value;
        }
        return $default;
    }

    /**
     * Returns the value of a SERVER parameter.
     *
     * @param  string $name The SERVER parameter name
     * @param  string $default The default value
     * @return string The SERVER parameter value
     */
    public function getServerParameter($name, $default = null)
    {
        if(isset($this->serverParameters[$name]))
        {
            $value = $this->serverParameters[$name];
            return $value;
        }
        return $default;
    }

    /**
     * Returns the value of a COOKIE parameter.
     *
     * @param  string $name The COOKIE parameter name
     * @param  string $default The default value
     * @return string The COOKIE parameter value
     */
    public function getCookieParameter($name, $default = null)
    {
        if(isset($this->cookieParameters[$name]))
        {
            $value = $this->cookieParameters[$name];
            return $value;
        }
        return $default;
    }

    /**
     * les parametres post
     */
    public function getPostParameters()
    {
        return $this->postParameters;
    }


}