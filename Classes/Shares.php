<?php
    namespace Classes;

    class Shares {

        private $code;
        private $name;
        private $price;
        private $capital;

        public function __construct($code, $name)
        {
            $this->code = $code;
            $this->name = $name;

            return $this;
        }

        public function setPrice($price)
        {
            $this->price = $price;
            return $this;
        }

        public function returnPrice()
        {
            return $this->price;
        }

        public function returnCapital()
        {
            return $this->capital;
        }

        public function setCapital($capital)
        {
            $this->capital = $capital;
            return $this;
        }

        public function numberShares()
        {
            return $this->capital / $this->price;
        }
}
?>