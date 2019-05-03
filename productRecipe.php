<?php
include_once 'config.php';
include_once constant("MODEL_DIR").'dao/ProductIngredientDAO.php';
include_once constant("MODEL_DIR").'ProductRecipeResponseBuilder.php';
$responseGetter=new ApiResponseGetter();
echo $responseGetter->get('productRecipe');
?>
