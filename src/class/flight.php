<?php 

    class Flight
    {
            //get airline from name
            function getAirline($db, $name)
            {
                $sql = "SELECT name, code FROM trip.airlines as airline WHERE `name` = :name"; 
                try
                {
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

            function getDirectFlight($db, $departCityCode, $arriveCityCode, $departureDate)
            {
                $sql = "SELECT * FROM trip.flights as flight WHERE `departure_airport` = :departCityCode AND `arrival_airport` = :arriveCityCode AND `departure_time` >= :departureDate AND `departure_time` < (:departureDate + INTERVAL 1 DAY) ORDER BY `price` ASC"; 
                try
                {
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
    }
?>