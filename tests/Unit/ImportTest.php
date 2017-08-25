<?php
    use PHPUnit\Framework\TestCase;
    USE Core\Journey;

    class ImportTest extends TestCase
    {
        var $jsonFile = "test.json";

        public function setUp()
        {
            parent::setUp();
            $this->journey = new Journey;

        }

        /**
         * @test
         */
        public function json_source_assigned_correctly()
        {
            $this->journey->setJsonSource($this->jsonFile);
            $this->assertTrue($this->journey->getJsonSource() == $this->jsonFile);
        }

        /**
         * @test
         */
        public function found_start_and_end_of_journey()
        {
            $this->journey->setJsonSource($this->jsonFile);
            $this->journey->parse();
            $this->assertEquals('Madrid', $this->journey->getStartLocation());
            $this->assertEquals('LAX', $this->journey->getEndLocation());

        }






    }