<?php
include_once 'config.php';
include_once constant("MODEL_DIR").'dao/ProductDAO.php';
include_once constant("MODEL_DIR").'ProductResponseBuilder.php';
$responseGetter=new ServerApiResponseGetter();
$responseGetter->get('product');
?>
