<?php
    namespace Core;
    class Transport
    {
        public $type = '';  // transport type
        public $start = ''; //
        public $end = '';
        public $seatNumber = '';
        public $instructions = '';

        var $data;

        function __construct($params)
        {
            //$this->setVars(get_object_vars($params));
            $this->data = get_object_vars($params);
            $this->setVars();
        }

        /**
         * @return string
         */
        public function getInstructions()
        {
            return $this->instructions;
        }

        public function setVars()
        {
            $this->type = $this->data['type'];
            $this->start = $this->data['from'];
            $this->end = $this->data['to'];
            $this->seatNumber = array_key_exists('seat', $this->data) ? $this->data['seat'] : false;
            $this->instructions = $this->InstructionBuilder();
        }

        /**
         * Build journey leg instructions based on available data
         *
         * @return string
         */
        public function InstructionBuilder()
        {
            $i = "Take the " . $this->type . " from " . $this->start . " to " . $this->end . ".";
            if ($this->seatNumber) {
                $i .= " Sit in seat " . $this->seatNumber;
            } else $i .= " No seat assignment";
            return $i;
        }

    }

