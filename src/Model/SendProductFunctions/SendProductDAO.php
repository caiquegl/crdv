<?php

namespace CRDV\Model\SendProductFunctions;

interface SendProductDAO {
    public function calcPriceDeadlineByPost(SendProduct $product);
    public function jsonify($response);
    public function setHeaders();
    public function setParams($product);
}