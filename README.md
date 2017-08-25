# Technical Test: Trip Sorter
Given a sample JSON file, the task is to produce a solution, runnable from the command line, which will accept a list of unsorted boarding passes and return a human readable list, like the following example:
1. Take train 78A from Madrid to Barcelona. Sit in seat 45B. 
2. Take the airport bus from Barcelona to Gerona Airport. No seat assignment. 
3. From Gerona Airport, take flight SK455 to Stockholm. Gate 45B, seat 3A. Baggage drop at ticket counter 344. 
4. From Stockholm, take flight SK22 to New York JFK. Gate 22, seat 7B. Baggage will be automatically transferred from your last leg. 
5. You have arrived at your final destination.

 
## Assumptions

* Only one ticket exists for each journey leg (no duplicates)
* Each location is only visited once (no round trip)
* Json string will only contain the data for one Journey
  

## Observations
* Of the minimum data stated the "seat assignment" is missing from one record. The example output also assumes this field is not mandatory therefore the code assumes the same     


## Running this code
Navigate to the directory where you have placed the code and run the following command in your command line  (assuming the php executeable is in your path): 

```command
php run.php
```

### Adding new types of transport to the JSON data
The Transport class handles any mode of transport without needing to change code however the class can be extended by creating a new extended class in "./core/Transport".
  The file and class name should be the name of the mode of transport with all white space removed and the first letter capitalised.
   
   The example below extends the transport type for "Banana Boat" (filename: "Bananaboat.php")
   
```php
<?php
    namespace Core\Transport;

    use Core\Transport;

    class Bananaboat extends Transport
    {
        function __construct($params)
        {
            parent::__construct($params);
            $this->instructions = str_replace('Banana Boat', 'Kayak', $this->instructions);
        }
    }   
```

## Unit tests
Unit testing is confined 2 tests and 3 assertions as there isn't much functionality to test
 
 Tests for this project are in "tests/Unit/" and the json file for testing is in the root folder, named "test.json".
 
 To run the unit test from the command line navigate to the source code and use the following command:

```command
php vendor/phpunit/phpunit/phpunit
```

## Third Party Software
Composer is used to set up autoloading and download the phpunit testing package plus dependencies. To ensure this project runs without third party software delete or rename the vendor directory and run from the command line as normal (testing wont be possible in this scenario).
