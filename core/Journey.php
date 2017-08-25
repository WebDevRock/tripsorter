<?php
    namespace Core;
    class Journey
    {
        private $jsonSource = '';
        private $locations = [];
        public $startLocation = '';
        public $endLocation = '';
        private $legs = [];

        /**
         * @return string
         */
        public function getName()
        {
            return $this->name;
        }

        /**
         * @param $string
         */
        public function setJsonSource($string)
        {
            $this->jsonSource = $string;
        }

        /**
         * @return string
         */
        public function getJsonSource()
        {
            return $this->jsonSource;
        }

        /**
         * @return string
         */
        public function getStartLocation()
        {
            return $this->startLocation;
        }

        /**
         * @return string
         */
        public function getEndLocation()
        {
            return $this->endLocation;
        }

        /**
         *
         */
        public function parse()
        {
            // Test jsonSource for a URL
            if (!filter_var($this->jsonSource, FILTER_VALIDATE_URL)) {
                // Not a URL therefore check if file exists
                if (!file_exists($this->jsonSource)) {
                    throw new \Exception("File does not exist ({$this->jsonSource})");
                }
            }
            $string = file_get_contents($this->jsonSource);
            $json = json_decode($string);
            // check json was formatted correctly
            if (is_null($json)) throw new \Exception("Data improperly formatted");
            /*
             * Loop through each leg of the journey and set  up the data
             */
            for ($x = 0; $x < count($json); $x++) {
                // check data for minimum data (type, from, to)
                if (!array_key_exists('type', $json[$x])) {
                    throw new \Exception("Mandatory field 'type' is missing from data source.");
                }
                if (!array_key_exists('from', $json[$x])) {
                    throw new \Exception("Mandatory field 'from' is missing from data source.");
                }
                if (!array_key_exists('to', $json[$x])) {
                    throw new \Exception("Mandatory field 'to' is missing from data source.");
                }

                // remove whitespace and capitalise the first letter to format a class name and all other letters lower case
                $transport = ucfirst(strtolower(preg_replace('/\s+/', '', $json[$x]->type)));
                $cname = "Core\\Transport\\" . $transport;
                // Check for named class of specific transport type ($transport) and instantiate if exists
                if (class_exists($cname)) {
                    $leg = new $cname($json[$x]);
                } else {
                    // otherwise instantiate the default class
                    $leg = new Transport($json[$x]);
                }
                $this->legs[$leg->start] = $leg;  // Assuming we are visiting a destination only once in the journey
                /*
                 * Build an array of locations on the journey with a count of how many times the location appears on a ticket.
                 * The start and end of the journey will only appear once throughout the journey
                 */
                if (array_key_exists($json[$x]->from, $this->locations)) {
                    $this->locations[$json[$x]->from]['count'] = $this->locations[$json[$x]->from]['count'] + 1;
                } else {
                    $this->locations[$json[$x]->from]['count'] = 1;
                    $this->startLocation = $json[$x]->from;
                }
                if (array_key_exists($json[$x]->to, $this->locations)) {
                    $this->locations[$json[$x]->to]['count'] = $this->locations[$json[$x]->to]['count'] + 1;
                } else {
                    $this->locations[$json[$x]->to]['count'] = 1;
                    $this->endLocation = $json[$x]->to;
                }
            }
            // Sort out the journey and show
            $this->showJourney();
        }

        /**
         *  Output each leg of the journey to the screen in order of travel
         */
        private function showJourney()
        {
            echo PHP_EOL;
            // set the first start location
            $from = $this->startLocation;
            $i = 1; // line numbering
            //find and echo out each leg of the journey until we run out of legs
            while ($leg = $this->findLegById($from)) {
                // set the start of the next leg to the destination of this one
                $from = $leg->end;
                echo $i . ". " . $leg->instructions . PHP_EOL;
                $i++;
            }
            echo "{$i}. You have arrived at your final destination." . PHP_EOL;
        }

        /**
         * @param $id
         * @return bool|mixed
         */
        private function findLegById($id)
        {
            if (isset($this->legs[$id])) {
                return $this->legs[$id];
            }
            return false;
        }

    }

