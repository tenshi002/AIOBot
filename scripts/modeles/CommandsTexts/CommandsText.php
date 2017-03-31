<?php
namespace modeles\CommandsTexts;
use DOMNode;
use lib\Application;

/**
 * Created by IntelliJ IDEA.
 * User: Tenshi002
 * Date: 31/03/2017
 * Time: 00:12
 */
class CommandsText
{
    const NODE_NAME = 'commandText';
    private $name;
    private $arguments;
    /**
     * @var text[]
     */
    private $texts = array();
    private $logger;

    private $mappingAttributes = array(
        'name' => 'name',
        'arguments' => 'arguments'
    );

    public function __construct(\DOMElement $nodeCommandText = null)
    {
        $this->logger = Application::getInstance()->getLogger();
        if(isset($nodeCommandText) && !is_null($nodeCommandText))
        {
            foreach($this->mappingAttributes as $attributeClasse => $attributeXml)
            {
                $setter = 'set' . ucfirst($attributeClasse);
                $this->$setter($nodeCommandText->getAttribute(utf8_encode($attributeXml)));
            }

            $childsNodesText = $nodeCommandText->getElementsByTagName(text::NODE_TEXT);
            if($childsNodesText->length > 0)
            {
                foreach($childsNodesText as $nodeText)
                {
                    $text = new text($nodeText);
                    $this->texts[] = $text;
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
     * @return mixed
     */
    public function getArguments()
    {
        return $this->arguments;
    }

    /**
     * @param mixed $arguments
     */
    public function setArguments($arguments)
    {
        $this->arguments = $arguments;
    }

    /**
     * @return text[]
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