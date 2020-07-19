<?php

/**
 * Class People
 */
class People {

    /**
     * @var Service
     */
    protected $service;

    /**
     * People constructor.
     * @param Service $service
     */
    public function __construct
    (
        Service $service
    ) {
        $this->service = $service;
    }

    /**
     * Get content to be display.
     *
     * @param $key
     * @param string $petType
     * @param bool $isSort
     * @return string
     */
    public function getContent($key, $petType = 'cat', $isSort = true) {
        $html = '';

        $data = $this->service->getDataByKey($key, $petType);

        if (empty(!$data)) {
            foreach ($data as $key => $value) {
                $html .= '<h5>' . $key . '</h5>';

                if ($isSort) {
                    sort($value);
                }

                $html .= '<ul>';
                foreach ($value as $v) {
                    $html .= '<li>' . $v . '</li>';
                }
                $html .= '</ul>';
            }
        }else {
            $html .= '<h5>There are no results to display.</h5>';
        }

        return $html;
    }

}