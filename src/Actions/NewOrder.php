<?php

namespace Bdok\PostGateway\Actions;

use Bdok\PostGateway\Exceptions\ValidationException;

trait NewOrder
{
    /**
     * Create new order.
     *
     * @param array $data
     *
     * @return array
     */
    public function newOrder(array $data)
    {
        $dataString = $this->buildDataString($data);
        $data = [
            'action' => 'newOrder',
            'data'   => $dataString,
        ];

        return $this->retry(30, function () use ($data) {
            $result = $this->post('post.php', $data)['message']['data'];
            $result = explode('^', $result);

            return $result;
        });
    }

    /**
     * Build Data string.
     *
     * @param array $data
     *
     * @throws ValidationException
     *
     * @return string
     */
    protected function buildDataString(array $data)
    {
        $finalString = '';
        $requiredFields = ['customerPhone', 'reference', 'state', 'city', 'names', 'weight', 'price', 'shipment', 'payment', 'customerName', 'address', 'postalCode', 'customerEmail'];
        foreach ($requiredFields as $field) {
            foreach ($data as $key => $val) {
                if (!isset($data[$field])) {
                    throw new ValidationException([]);
                }
            }

            $finalString .= $data[$field].'^';
        }

        $price = $this->getPrice([
            'weight' => $data['weight'],
            'price'  => $data['price'],
            'state'  => $data['state'],
            'city'   => $data['city'],
            'tip'    => $data['shipment'],
            'cod'    => $data['payment'],
        ]);

        $finalString .= '0^'.$price[0].'^'.$price[2]; // remember that we already ends string with ^

        return trim($finalString, '^');
    }
}
