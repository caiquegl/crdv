<?php
namespace CRDV\Model\ProductFunctions;

interface ProductDAO{
    public function selectAll();
    public function selectAllForIndex();
    public function findById(Int $id);
    public function findBySKU(String $SKU);
    public function findByName(String $name);
    public function findBySector(String $sector);
    public function findByMSC(String $sector);
    public function registerProduct(Product $product);
    public function alterProduct(Product $product, Int $id);
    public function removeProduct(Int $id);
}