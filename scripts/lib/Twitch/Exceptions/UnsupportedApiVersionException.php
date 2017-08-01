<?php

namespace lib\Twitch\Exceptions;

class UnsupportedApiVersionException extends TwitchApiException
{
    public function __construct()
    {
        parent::__construct('Unsupported Twitch API Version');
    }
}
