<?php
    class Filter{
        
        function haversine($origem, $destino)
        {
            $raioTerra = 6371000;

            $latDe = deg2rad($origem['lat']);
            $longDe = deg2rad($origem['lon']);
            $latPara = deg2rad($destino['lat']);
            $longPara = deg2rad($destino['lon']);

            $latDelta = $latPara - $latDe;
            $lonDelta = $longPara - $longDe;

            $angulo = 2 * asin(sqrt(pow(sin($latDelta / 2), 2) + cos($latDe) * cos($latPara) * pow(sin($lonDelta / 2), 2)));
            return ($angulo * $raioTerra)/1000;
        }

    }