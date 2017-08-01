<?php

namespace lib\Twitch\Api;

use lib\Twitch\Exceptions\InvalidIdentifierException;
use lib\Twitch\Exceptions\InvalidLimitException;
use lib\Twitch\Exceptions\InvalidOffsetException;
use lib\Twitch\Exceptions\InvalidTypeException;
use lib\Twitch\Exceptions\UnsupportedOptionException;

trait Videos
{
    /**
     * Get a video
     *
     * @param int|string $videoIdentifier
     * @return array|json
     */
    public function getVideo($videoIdentifier)
    {
        if ($this->apiVersionIsGreaterThanV4() && !is_numeric($videoIdentifier)) {
            throw new InvalidIdentifierException('video');
        }

        return $this->get(sprintf('videos/%s', $videoIdentifier));
    }

    /**
     * Get top videos
     *
     * @param int    $limit
     * @param int    $offset
     * @param string $gamme
     * @param string $period
     * @param string $broadcastType (comma-seperated list)
     * @throws InvalidLimitException
     * @throws InvalidOffsetException
     * @throws InvalidTypeException
     * @throws UnsupportedOptionException
     * @return array|json
     */
    public function getTopVideos($limit = 10, $offset = 0, $game = null, $period = 'week', $broadcastType = 'highlight')
    {
        $validPeriods = ['week', 'month', 'all'];

        if (!$this->isValidLimit($limit)) {
            throw new InvalidLimitException();
        }

        if (!$this->isValidOffset($offset)) {
            throw new InvalidOffsetException();
        }

        if ($game && !is_string($game)) {
            throw new InvalidTypeException('game', 'string', gettype($game));
        }

        if (!in_array($period = strtolower($period), $validPeriods)) {
            throw new UnsupportedOptionException('period', $validPeriods);
        }

        $broadcastType = trim($broadcastType, ', ');
        if (!$this->isValidBroadcastType($broadcastType)) {
            throw new UnsupportedOptionException('broadcastType', $validBroadcastTypes);
        }

        $params = [
            'limit' => intval($limit),
            'offset' => intval($offset),
            'game' => $game,
            'period' => $period,
            'broadcast_type' => $broadcastType,
        ];

        return $this->get('videos/top', $params);
    }

    /**
     * Get the videos from channels followed by the authenticated user
     *
     * @param string $accessToken
     * @param int    $limit
     * @param int    $offset
     * @param string $broadcastType (comma-seperated list)
     * @throws InvalidLimitException
     * @throws InvalidOffsetException
     * @throws UnsupportedOptionException
     * @return array|json
     */
    public function getFollowedChannelsVideos($accessToken, $limit = 10, $offset = 0, $broadcastType = 'highlight')
    {
        if (!$this->isValidLimit($limit)) {
            throw new InvalidLimitException();
        }

        if (!$this->isValidOffset($offset)) {
            throw new InvalidOffsetException();
        }

        $broadcastType = trim($broadcastType, ', ');
        if (!$this->isValidBroadcastType($broadcastType)) {
            throw new UnsupportedOptionException('broadcastType', $validBroadcastTypes);
        }

        $params = [
            'limit' => intval($limit),
            'offset' => intval($offset),
            'broadcast_type' => $broadcastType,
        ];

        return $this->get('videos/followed', $params, $accessToken);
    }
}
