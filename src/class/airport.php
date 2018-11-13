<?php
    class  Airport
    {
        // getAirport
        function getAirport($db, $code)
        {
            $sql = "SELECT * FROM trip.airports as airport INNER JOIN trip.city as city ON airport.code = :code AND airport.city_id = city.id" ; 
            try
            {
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
        function getCode($db, $id, $tripType)
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

    }
?>