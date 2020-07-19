<?php

/**
 * Class CustomException
 */
class CustomException extends \Exception {

    /**
     * Get Error message string.
     *
     * @return string
     */
    public function errorString() {
        return 'Error found: ';
    }

}