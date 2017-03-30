<?php
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


    public function __construct()
    {
        $logger = Application::getInstance()->getLogger();

        if(!file_exists($this->filepath))
        {
            $logger->addError('Le fichier contenant les texts randoms n\'existe pas ...');
        }
        else
        {
            $xmlParser = new xmlParser($this->filepath);
            $nodesCommandText = $xmlParser->getNodes('CommandText');
            if($nodesCommandText->length > 0)
            {
                foreach($nodesCommandText as $nodeCommandText)
                {
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
     * @return array
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