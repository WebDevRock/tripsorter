<?php
    namespace Core\Transport;

    use Core\Transport;

    class Train extends Transport
    {
        public $baggage = 'Undefined';
        public $train = '';

        function __construct($params)
        {
            parent::__construct($params);
        }

        /**
         * Build journey leg instructions based on available data
         *
         * @return string
         */
        public function InstructionBuilder(){
            $i = "Take train ";
            $i .= (isset($this->data['train']) and !$this->data['train'] =='') ? "{$this->data['train']} " : "";
            $i .= "from {$this->start} to {$this->end}.";
            if($this->seatNumber) {
                $i.= " Sit in seat {$this->seatNumber}";
            }
            else $i.= " No seat assignment";
            return $i;
        }

    }