<?php
include_once 'config.php';
include_once constant("MODEL_DIR").'dao/RestaurantProductDAO.php';
include_once constant("MODEL_DIR").'RestaurantProductResponseBuilder.php';
$responseGetter=new ApiResponseGetter();
echo $responseGetter->get('restaurantProduct');
?>
