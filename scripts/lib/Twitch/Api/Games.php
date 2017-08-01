<?php

namespace lib\Twitch\Api;

use lib\Twitch\Exceptions\InvalidLimitException;
use lib\Twitch\Exceptions\InvalidOffsetException;

trait Games
{
    /**
     * Get top games
     *
     * @param int $limit
     * @param int $offset
     * @throws InvalidLimitException
     * @throws InvalidOffsetException
     * @return array|json
     */
    public function getTopGames($limit = 10, $offset = 0)
    {
        if (!$this->isValidLimit($limit)) {
            throw new InvalidLimitException();
        }

        if (!$this->isValidOffset($offset)) {
            throw new InvalidOffsetException();
        }

        $params = [
            'limit' => $limit,
            'offset' => $offset,
        ];

        return $this->get('games/top', $params);
    }

}
