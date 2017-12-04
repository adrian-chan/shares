<?php
    namespace Classes;

    class Projections
    {
        protected $buyPrice;
        protected $numberShares;
        protected $acquisitionCost = 0;

        public function __construct()
        {
            return $this;
        }

        public function setBuyPrice($price)
        {
            $this->buyPrice = $price;
            return $this;
        }

        public function calculateNumberShares($capitalExpenditure)
        {
            $this->numberShares = number_format($capitalExpenditure / $this->buyPrice, 2);
            return $this;
        }

        public function setBuySellCost($buyCost, $sellCost)
        {
            $this->acquisitionCost = $buyCost + $sellCost;
            return $this;
        }

        public function gains($currentPrice)
        {
            return number_format(((($currentPrice - $this->buyPrice) / $this->buyPrice) * 100), 3);
        }

        public function value($currentPrice)
        {
            return (($currentPrice * $this->numberShares) - $this->acquisitionCost);
        }

        public function time_series($priceToStart, $priceToEnd, $increment)
        {
            $prices = [];
            $priceToStart   = number_format($priceToStart,3);
            $priceToEnd     = number_format($priceToEnd,3);
            $increment      = number_format($increment,3);

            $prices["buyPrice"] = $this->buyPrice;
            $prices["numberShares"] = $this->numberShares;

            if($priceToStart < $priceToEnd)
            {
                for ($i = $priceToStart; $i <= $priceToEnd; $i += $increment)
                {
                    $i = number_format($i, 3);
                    $prices[(string) $i]["gains"] = $this->gains($i);

                    if ($this->numberShares != null)
                    {
                        $prices[(string) $i]["value"] = $this->value($i);
                    }

                }
                return $prices;
            }
            else {
                Throw new \Exception("PriceStart is greater than PriceEnd");
            }

        }
    }
?>