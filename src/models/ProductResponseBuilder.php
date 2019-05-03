<?php
	//echo 'OrderPageBuilder: '.$_SERVER["PHP_SELF"];
	class ProductResponseBuilder implements ResponseBuilder{
		public function build($request){
			$adapter=new ProductDAO();
			$productIngredientDAO=new ProductIngredientDAO();
			if(isset($_GET['categoryId']) && is_numeric($_GET['categoryId'])){
				$products=$adapter->getProductsByCategoryId($_GET['categoryId']);
				if(isset($_GET['detail']) && $_GET['detail'] ==='ingredient'){
					foreach($products as &$product){
						$product['ingredients']=$productIngredientDAO->getAllIngredientByProductId($product['id']);
					}
				}
				if(!empty($products)) return json_encode(array('status'=>true,'code'=>SUCCEED,'products'=>$products));
				else return ServerApiResponseGetter::createResponse('false',E_NO_PRODUCT,'NO PRODUCT');
			}else if(isset($_GET['productId']) && is_numeric($_GET['productId'])){
				$product=$adapter->getProduct($_GET['productId']);
				if($product!==null){
					if(isset($_GET['detail']) && $_GET['detail'] ==='ingredient'){
						$product['ingredients']=$productIngredientDAO->getAllIngredientByProductId($product['id']);
					}
					return json_encode(array('status'=>true,'code'=>SUCCEED,'product'=>$product));
				}
				else return ServerApiResponseGetter::createResponse('false',E_NO_PRODUCT,'NO PRODUCT');
			}else{
				$products=$adapter->getAll();
				if(isset($_GET['detail']) && $_GET['detail'] ==='ingredient'){
					foreach($products as &$product){
						$product['ingredients']=$productIngredientDAO->getAllIngredientByProductId($product['id']);
					}
				}
				if(!empty($products)) return json_encode(array('status'=>true,'code'=>SUCCEED,'products'=>$products));
				else return ServerApiResponseGetter::createResponse('false',E_NO_PRODUCT,'NO PRODUCT');
			}
		}
	}
?>
