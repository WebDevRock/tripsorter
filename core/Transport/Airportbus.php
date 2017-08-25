<?php
    namespace Core\Transport;

    use Core\Transport;

    class Airportbus extends Transport
    {
        function __construct($params)
        {
            parent::__construct($params);
            $this->instructions = str_replace('airportbus', 'airport bus', $this->instructions); //translate the transport "type" output into proper english
        }
    }