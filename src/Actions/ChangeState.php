<?php

namespace Bdok\PostGateway\Actions;
use Bdok\PostGateway\Exceptions\ValidationException;

trait ChangeState
{
    /**
     * Change state of order
     * @param $tracking_number
     * @param $state
     * @return boolean
     * @throws ValidationException
     */
    public function changeState($tracking_number, $state)
    {
        if (
            !is_numeric($tracking_number) ||
            !in_array((int)$state, [1,2])
        ) {
            throw new ValidationException([]);
        }

        $data = ['action' => 'change'] + compact('tracking_number', 'state');
        $result = $this->post('post.php', $data)['message']['data']['status'];

        return $result;
    }
}