<?php

namespace lib\Twitch\Exceptions;

class UnsupportedOptionException extends TwitchApiException
{
    /**
     * @var string $options
     * @var array  $validOptions
     */
    public function __construct($option, $validOptions)
    {
        parent::__construct(sprintf('Unsupported option provided for \'%s\'. Valid options include: %s.', $option, implode(', ', $validOptions)));
    }
}
