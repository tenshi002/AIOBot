<?php
/**
 * Created by IntelliJ IDEA.
 * User: nico
 * Date: 19/07/17
 * Time: 17:42
 */

namespace controllers\Index;

use lib\Controller;

class IndexController extends Controller
{
    public function executeIndex()
    {
        $this->getHTTPResponse()->addTemplateVar('title', 'LOLPAGE');
    }
}