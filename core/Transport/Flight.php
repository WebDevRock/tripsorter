<?php
    namespace Core\Transport;

    use Core\Transport;

    class Flight extends Transport
    {
        public $baggage = '';
        public $gateNumber = '';

        function __construct($params)
        {
            parent::__construct($params);
        }

        /**
         * Build journey leg instructions based on available data
         *
         * @return string
         */
        public function InstructionBuilder()
        {

            $i = "From {$this->start} Take flight ";
            $i .= (isset($this->data['gate']) and !$this->data['gate'] =='') ? "{$this->data['flight']}" : "";
            $i .= "to {$this->end}. ";
            $i .= (isset($this->data['gate']) and !$this->data['gate'] =='') ?  "Gate {$this->data['gate']}, " : "No gate assigned, ";
            $i .= (isset($this->data['seat']) and !$this->data['seat'] =='') ?  "seat {$this->data['seat']}" : "No seat assigned. ";
            $i .= (isset($this->data['baggage']) and !$this->data['baggage'] =='') ?  ", {$this->data['baggage']}" : "";
            return $i;
        }

    }