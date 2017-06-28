<?php

namespace Bdok\PostGateway\Actions;

use Bdok\PostGateway\Exceptions\ValidationException;

trait GetPrice
{
    /**
     * Get shipping price
     * @param array $data
     * @return array
     * @throws ValidationException
     */
    public function getPrice(array $data)
    {
        $data = ['action' => 'getPrice'] + $data;
        $result = $this->post('post.php', $data)['message']['data'];
        $result = explode(';', $result);

        if (!is_array($result) || $result[0] == 1 || $result[1] == 0) {
            throw new ValidationException([]);
        }

        return $result;
    }
}