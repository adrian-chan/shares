<?php
    namespace Classes;

    class Projections
    {

        public function __construct()
        {
            return $this;
        }

        public function gains($buyPrice, $currentPrice)
        {
            return ((($currentPrice - $buyPrice) / $buyPrice) * 100);
        }
    }
?>