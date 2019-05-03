<?php
include_once 'config.php';
include_once constant("MODEL_DIR").'dao/IngredientDAO.php';
include_once constant("MODEL_DIR").'IngredientResponseBuilder.php';
$responseGetter=new ServerApiResponseGetter();
echo $responseGetter->get('ingredient');
?>
