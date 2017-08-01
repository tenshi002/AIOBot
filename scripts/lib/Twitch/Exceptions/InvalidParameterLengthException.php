<?php

namespace lib\Twitch\Exceptions;

class InvalidParameterLengthException extends TwitchApiException
{
    /**
     * @var string $paramName
     */
    public function __construct($paramName)
    {
        parent::__construct('Invalid string length provided for \'%s\'.');
    }
}
