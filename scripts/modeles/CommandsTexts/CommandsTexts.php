<?php
namespace modeles\CommandsTexts;

use lib\Application;
use lib\xmlParser;

/**
 * Created by IntelliJ IDEA.
 * User: Tenshi002
 * Date: 31/03/2017
 * Time: 00:09
 */
class CommandsTexts
{
    private $filepath = __DIR__ . '/../../../datas/CommandsText/commandsText.xml';

    /**
     * @var CommandsText[]
     */
    private $commandsTexts = array();
    private $logger;


    public function __construct()
    {
        $this->logger = Application::getInstance()->getLogger();

        if(!file_exists($this->filepath))
        {
            $this->logger->addError('Le fichier contenant les texts randoms n\'existe pas ...');
        }
        else
        {
            $xmlParser = new xmlParser($this->filepath);
            /** @var $nodesCommandText \DOMNodeList*/
            $nodesCommandsTexts = $xmlParser->getNodes(CommandsText::NODE_NAME);
            if($nodesCommandsTexts->length > 0)
            {
                /** @var $nodeCommandsText \DOMNode*/
                foreach($nodesCommandsTexts as $nodeCommandText)
                {
                    /** @var $nodeCommandText \DOMNode */
                    $commandText = new CommandsText($nodeCommandText);
                    $this->commandsTexts[] = $commandText;
                }
            }
        }
    }

    /**
     * @param $name
     * @return CommandsText|null
     */
    public function getCommandTextByName($name)
    {
        if(is_array($this->commandsTexts) && !empty($this->commandsTexts))
        {
            foreach($this->commandsTexts as $commandsText)
            {
                if($commandsText->getName() === $name)
                {
                    return $commandsText;
                }
            }
        }
        return null;
    }

    /**
     * @return CommandsText[]
     */
    public function getCommandsTexts()
    {
        return $this->commandsTexts;
    }

    /**
     * @param CommandsText[] $commandsTexts
     */
    public function setCommandsTexts($commandsTexts)
    {
        $this->commandsTexts = $commandsTexts;
    }

    /**
     * @param $commandtext CommandsText
     */
    public function addCommandText(CommandsText $commandtext)
    {
        $this->commandsTexts[] = $commandtext;
    }

}