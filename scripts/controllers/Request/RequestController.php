<?php
/**
 * Created by IntelliJ IDEA.
 * User: nico
 * Date: 04/08/17
 * Time: 10:58
 */

namespace controllers\Request;


use lib\Application;
use lib\Controller;
use lib\HTTP\HTTPResponse;

class RequestController extends Controller
{

    public function executeGetFlashMessageHTML()
    {
        $title = $this->getHTTPRequest()->getPostParameter('title');
        $message = $this->getHTTPRequest()->getPostParameter('message');
        $type = $this->getHTTPRequest()->getPostParameter('type');

        if(is_null($type))
        {
            $type = 'info';
        }

        $this->getHTTPResponse()->addTemplateVars(array(
            'title' => $title,
            'message' => $message,
            'type' => $type
        ));
        $this->getHTTPResponse()->setTemplate('flashMessage.twig');
    }

    public function executeCheckSessionFlashMessage()
    {
        $session = Application::getInstance()->getSession();
        $flash = false;
        if($session->getFlashMessage() !== null)
        {
            $flash = $session->getFlashMessage();
            $session->resetFlashMessage();
        }
        $this->getHTTPResponse()->setContentType(HTTPResponse::CONTENT_TYPE_JSON);
        $this->getHTTPResponse()->setContent(array('flashMessage' => $flash));
    }


}