<?php

/**
 * Created by IntelliJ IDEA.
 * User: Tenshi002
 * Date: 31/03/2017
 * Time: 00:12
 */
class CommandsText
{
    private $name;
    /**
     * @var text[]
     */
    private $texts = array();
    private $mappingAttributes = array(
        'name' => 'name'
    );

    public function __construct(DOMNode $nodeCommandText = null)
    {
        if(isset($nodeCommandText) && !is_null($nodeCommandText))
        {
            foreach($this->mappingAttributes as $attributeClasse => $attributeXml)
            {
                $setter = 'set' . ucfirst($attributeClasse);
                $this->$setter($nodeCommandText->getAttribute(utf8_encode($attributeXml)));
            }

            $childsNodesText = $nodeCommandText->childNodes;
            if($childsNodesText->length > 0)
            {
                foreach($childsNodesText as $nodeText)
                {
                    $text = new text($nodeText);
                    $texts[] = $text;
                }
            }
        }
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return Text[]
     */
    public function getTexts()
    {
        return $this->texts;
    }

    /**
     * @param array $texts
     */
    public function setTexts($texts)
    {
        $this->texts = $texts;
    }

}