<?php
namespace modeles\CommandsTexts;

use DOMElement;
use DOMNode;

/**
 * Created by IntelliJ IDEA.
 * User: Tenshi002
 * Date: 31/03/2017
 * Time: 00:13
 */
class Text
{
    const NODE_TEXT = 'text';
    private $id;
    private $text;

    private $mappingAttributes = array(
        'id' => 'id',
        'text' => 'texte'
    );

    public function __construct(DOMElement $nodeText = null)
    {
        if(isset($nodeText) && !is_null($nodeText))
        {
            foreach($this->mappingAttributes as $attributeClasse => $attributeXml)
            {
                $setter = 'set' . ucfirst($attributeClasse);
                $this->$setter($nodeText->getAttribute(utf8_encode($attributeXml)));
            }
        }
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getText()
    {
        return $this->text;
    }

    /**
     * @param mixed $text
     */
    public function setText($text)
    {
        $this->text = $text;
    }

}