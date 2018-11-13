<?php

    class  City
    {

        public function getCities($db)
        {
            $sql = "SELECT * FROM trip.city" ;
            try{
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