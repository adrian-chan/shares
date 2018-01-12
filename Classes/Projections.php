<?php
    namespace Classes;

    use Classes\Shares;

    class Projections
    {
        protected $currentPrice;
        protected $numberShares;
        protected $acquisitionCost = 0;
        protected $shares;

        public function __construct(Shares $shares)
        {
            $this->shares = $shares;
            return $this;
        }

        public function setCurrentPrice($price)
        {
            $this->setCurrentPrice = $price;
            return $this;
        }

        public function setBuySellCost($buyCost, $sellCost)
        {
            $this->acquisitionCost = $buyCost + $sellCost;
            return $this;
        }

        public function gains($price)
        {
            $price = $this->value($price);
            return number_format(((($price - $this->shares->returnCapital()) / $this->shares->returnCapital()) * 100), 3);
        }

        public function value($price)
        {
            return (($price * $this->shares->numberShares()) - $this->acquisitionCost);
        }

        /*
         * price per share in relation to capital expenditure
         */
        public function projectPercent($percent)
        {
            $percent            = $percent / 100;
            $totalcapital       = $this->shares->returnCapital() + $this->acquisitionCost;
            $priceAtPercentGain = $totalcapital + ($totalcapital * $percent);
            $numberOfShares     = $this->shares->numberShares();

            $pricePerShare = $priceAtPercentGain / $numberOfShares;

            $value = [];
            //$value['total_capital']    = $totalcapital;
            $value["initial"]['capital'] = number_format($this->shares->returnCapital(), 3);
            $value["initial"]['buy_price'] = number_format($this->shares->returnPrice(), 3);

            $value['percentage']      = $percent;
            $value['price']           = number_format($priceAtPercentGain, 3);
            $value['price_per_share'] = number_format($pricePerShare, 3);

            return $value;
        }

        public function time_series($priceToStart, $priceToEnd, $increment)
        {
            $prices = [];
            $priceToStart   = number_format($priceToStart,3);
            $priceToEnd     = number_format($priceToEnd,3);
            $increment      = number_format($increment,3);

            $prices["buyPrice"] = $this->shares->returnPrice();
            $prices["numberShares"] = $this->shares->numberShares();

            if($priceToStart < $priceToEnd)
            {
                for ($i = $priceToStart; $i <= $priceToEnd; $i += $increment)
                {
                    $i = number_format($i, 3);
                    $prices[(string) $i]["percentage_gains"] = $this->gains($i);
                    $prices[(string) $i]["value"] = $this->value($i);

                }
                return $prices;
            }
            else {
                Throw new \Exception("PriceStart is greater than PriceEnd");
            }
        }

        public function breakEvenPrice()
        {
            return $this->projectPercent(0);
        }
    }
?>