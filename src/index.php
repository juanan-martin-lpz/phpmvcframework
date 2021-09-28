<?php

require 'Controllers/RequestDispatcher.php';
require 'Controllers/DefaultRouter.php';

$router = new DefaultRouter();

$dispatcher = new RequestDispatcher($router);

$dispatcher->dispatch();


?>
