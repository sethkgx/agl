<?php

require 'CustomException.php';

/**
 * Class Service
 */
class Service {

    /**
     * @var string
     */
    private $url = 'http://agl-developer-test.azurewebsites.net/people.json';

    /**
     * @var string
     */
    const PETS = 'pets';

    /**
     * Decode data.
     *
     * @param $data
     * @return array|mixed
     */
    protected function decode($data) {
        if (empty($data)) {
            return [];
        }

        return json_decode($data, true);
    }

    /**
     * Get Data by key.
     *
     * @param $key
     * @param $petType
     * @return array
     * @throws CustomException
     */
    public function getDataByKey($key, $petType) {
        $json = file_get_contents($this->url);
        $values = $this->decode($json);
        $data = [];

        if (empty($values)) {
            throw new CustomException('Unable to access endpoint. Please try again later.');
        }

        $petCount = 0;
        $pets = [];
        foreach ($values as $value) {

            if (!array_key_exists($key, $value)) {
                throw new CustomException(
                    sprintf('Invalid field. For reference here are the list of valid fields: <b>%s</b>', implode(', ', array_keys($value)))
                );
            }

            if (isset($value[self::PETS]) &&count($value[self::PETS]) > 0) {
                foreach ($value[self::PETS] as $pet) {

                    $pets[] = $pet['type'];

                    if (isset($value[$key]) && isset($pet['type']) && isset($pet['name'])) {
                        if (strtolower($pet['type']) == strtolower($petType)) {
                            $data[$value[$key]][] = $pet['name'];
                            $petCount++;
                        }
                    }
                }
            }

        }

        if ($petCount == 0) {
            throw new CustomException(
                sprintf('Pet type not found. For reference here are the list of valid pet types: <b>%s</b>', implode(', ', array_unique($pets)))
            );
        }

        return $data;
    }

}