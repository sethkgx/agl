<?php
require "People.php";
require "Service.php";

$service = new Service();
$block = new People($service);

try {
    echo $block->getContent('gender', 'cat', true);
} catch (CustomException $e) {
    echo $e->errorString() . $e->getMessage();
} catch (Exception $e) {
    echo $e->getMessage();
}