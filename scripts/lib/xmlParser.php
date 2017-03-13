<?php
/**
 * Created by IntelliJ IDEA.
 * User: ssouppaya
 * Date: 08/03/17
 * Time: 16:08
 */

namespace lib;


use DOMDocument;
use DOMXPath;

class xmlParser
{

    /**
     * @var string
     */
    private $pathfile;
    /**
     * @var DOMDocument
     */
    private $xmlFile;

    /**
     * @var DOMXPath
     */
    private $domParser;


    public function __construct($pathfile)
    {
        $this->pathfile = $pathfile;

        $this->xmlFile = new DOMDocument();
        $this->xmlFile->load($pathfile);

        $this->domParser = new DOMXPath($this->xmlFile);
    }


    /**
     * On renvoie les noeuds donnés en paramètre
     * @param $noeud
     * @return bool|\DOMNodeList
     */
    public function getNodes($noeud)
    {
        $noeuds = $this->domParser->query('//' . $noeud);
        if($noeuds->length > 0)
        {
            return $noeuds;
        }
        return false;
    }

    public function getNodeByQuery($query)
    {
        $node = $this->domParser->query(utf8_encode($query));
        if($node->length > 0)
        {
            return $node;
        }
        return false;
    }

    public function getAttributFromNode(\DOMElement $node, $attribut)
    {
        $value = $node->getAttribute($attribut);

        if(isset($value) && $value !== '')
        {
            return $value;
        }
        return false;
    }

}