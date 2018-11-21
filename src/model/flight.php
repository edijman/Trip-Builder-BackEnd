<?php 
    class Flight
    {
        //get airline from name
        function getAirline($name){
            $sql = "SELECT name, code FROM trip.airlines as airline WHERE `name` = :name"; 
            try
            {
                $db = new db();
                $db = $db->connect();
                $stmt = $db->prepare($sql);
                $stmt->bindParam(':name', $name);
                $stmt->execute();
                $airlines = $stmt->fetchAll(PDO::FETCH_ASSOC);
                $db = null;

                return $airlines;
                
            }
            catch(PDOException $e){
                echo $e->getMessage();
            }
        }

        function getDirectFlight($departCityCode, $arriveCityCode, $departureDate)
        {
            $sql = "SELECT * FROM trip.flights as flight WHERE `departure_airport` = :departCityCode AND `arrival_airport` = :arriveCityCode AND `departure_time` >= :departureDate AND `departure_time` < (:departureDate + INTERVAL 1 DAY) ORDER BY `price` ASC"; 
            try
            {
                $db = new db();
                $db = $db->connect();
                $stmt = $db->prepare($sql);
                $stmt->bindParam(':departCityCode', $departCityCode);
                $stmt->bindParam(':arriveCityCode', $arriveCityCode);
                $stmt->bindParam(':departureDate', $departureDate);
                $stmt->execute();
                $flight = $stmt->fetchAll(PDO::FETCH_ASSOC);
                $db = null;

                return $flight;
                
            }
            catch(PDOException $e){
                echo $e->getMessage();
            }
        }

            // getAirport
        function getAirport($code)
        {
            $sql = "SELECT * FROM trip.airports as airport INNER JOIN trip.city as city ON airport.code = :code AND airport.city_id = city.id" ; 
            try
            {
                $db = new db();
                $db = $db->connect();
                $stmt = $db->prepare($sql);
                $stmt->bindParam(':code', $code);
                $stmt->execute();
                $airport = $stmt->fetchAll(PDO::FETCH_ASSOC);
                $db = null;
                return $airport;
                
            }
            catch(PDOException $e){
                echo $e->getMessage();
            }
        }

        //get Airport code based on the city
        function getCode($id, $tripType)
        {
            if($tripType == 'arrival' )
            {
                $sql = "SELECT code FROM trip.airports as airport INNER JOIN trip.flights as flight ON airport.code = flight.arrival_airport  WHERE `city_id` = :id";
            }
            else if($tripType == 'departure')
            {
                $sql = "SELECT code FROM trip.airports as airport INNER JOIN trip.flights as flight ON airport.code = flight.departure_airport  WHERE `city_id` = :id"; 
            }
            try
            {
                $db = new db();
                $db = $db->connect();
                $stmt = $db->prepare($sql);
                $stmt->bindParam(':id', $id);
                $stmt->execute();
                $Airport_code = $stmt->fetchAll(PDO::FETCH_ASSOC);
                $db = null;
                // echo 'Arrival'.$Airport_code[0]["code"];
                return $Airport_code[0]["code"];
                
            }
            catch(PDOException $e){
                echo $e->getMessage();
            }
            return 'Airport does not exist';

        }

       function getCities()
        {
            $sql = "SELECT * FROM trip.city" ;
            try{
                $db = new db();
                $db = $db->connect();
                $stmt = $db->prepare($sql);
                $stmt->execute();
                $cities = $stmt->fetchAll(PDO::FETCH_OBJ);
                $db = null;
                return $cities;
            }
            catch(PDOException $e){
                return $e->getMessage();
            }
        }
    }
?>