<?php
    use Core\Journey;
    use Core\JourneyLeg;

    require 'vendor/autoload.php';
    $journey = new Journey();
    //$journey->setJsonSource("http://jsonbin.io/b/599a8f1d45052906015a1d4e");
    $journey->setJsonSource("trip.json");
    $journey->parse();