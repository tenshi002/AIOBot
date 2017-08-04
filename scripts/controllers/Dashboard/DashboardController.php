<?php

namespace controllers\Dashboard;

use lib\Application;
use lib\Controller;
use lib\HTTP\HTTPResponse;
use lib\Session;

class DashboardController extends Controller
{
    public function executeIndex()
    {
        $this->checkAuthOrRedirect();
        $session = Application::getInstance()->getSession();
        $user = $session->getUserFromSession();
        $this->getHTTPResponse()->addTemplateVar('user', $user);
    }

    public function executeSaveModeration()
    {
        $botAntiLink = $this->getHTTPRequest()->getPostParameter('bot_filtre_link', false);
        $botActiveClip = $this->getHTTPRequest()->getPostParameter('bot_clip_link', false);
        $botAntiMaj = $this->getHTTPRequest()->getPostParameter('bot_maj_spam', false);
        $botAntiSpam = $this->getHTTPRequest()->getPostParameter('bot_emote_spam', false);

        $user = Application::getInstance()->getSession()->getUserFromSession();
        if($botAntiLink !== false)
        {
            $user->setBotAntiLink(true);
        } else {
            $user->setBotAntiLink(false);
        }
        if($botActiveClip !== false)
        {
            $user->setBotActiveClip(true);
        } else {
            $user->setBotActiveClip(false);
        }
        if($botAntiMaj !== false)
        {
            $user->setBotAntiMaj(true);
        } else {
            $user->setBotAntiMaj(false);
        }
        if($botAntiSpam !== false)
        {
            $user->setBotAntiSpam(true);
        } else {
            $user->setBotAntiSpam(false);
        }

        $em = Application::getInstance()->getEntityManager();
        $em->persist($user);
        $em->flush();
        $this->getHTTPResponse()->setContentType(HTTPResponse::CONTENT_TYPE_JSON);
        $this->getHTTPResponse()->setJSONFlashMessageContent(
            'Sauvegarde effectuée',
            'Les modifications apportées aux options de modérations ont bien été prises en compte',
            'success'
        );
    }
}