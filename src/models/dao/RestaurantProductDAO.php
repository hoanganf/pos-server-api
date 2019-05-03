<?php
class RestaurantProductDAO extends BaseDAO{
  function __construct(){
     parent::__construct("restaurant_product");
  }
  function getAllRestaurantByProductId($productId){
    return $this->getAllQuery('SELECT r.id,r.name,r.phone,address,r.image,r.description FROM restaurant_product rp LEFT JOIN restaurant r ON r.id=rp.restaurant_id WHERE product_id='.$productId.' AND rp.available=1');
  }
}
?>
