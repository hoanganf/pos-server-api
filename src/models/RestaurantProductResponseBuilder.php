<?php
	//echo 'OrderPageBuilder: '.$_SERVER["PHP_SELF"];
	class RestaurantProductResponseBuilder implements ResponseBuilder{
		public function build($request){
			$adapter=new RestaurantProductDAO();
			if(isset($_GET['productId']) && is_numeric($_GET['productId'])){
				$result=$adapter->getAllRestaurantByProductId($_GET['productId']);
				if(!empty($result)) return json_encode(array('status'=>true,'code'=>SUCCEED,'restaurants'=>$result));
				else return ApiResponseGetter::createResponse('false',E_NO_RESTAURANT,'NO RESTAURANT');
			}/* TODO else if(isset($_GET['restaurantId']) && is_numeric($_GET['restaurantId'])){
				$product=$adapter->getProduct($_GET['productId']);
				if($product!==null) return json_encode(array('status'=>true,'code'=>SUCCEED,'product'=>$product),true);
				else return ApiResponseGetter::createResponse('false',E_NO_PRODUCT,'NO PRODUCT');
			}else{
				$products=$adapter->getAll();
				if(!empty($products)) return json_encode(array('status'=>true,'code'=>SUCCEED,'products'=>$products),true);
				else return ApiResponseGetter::createResponse('false',E_NO_PRODUCT,'NO PRODUCT');
			}*/
			else return ApiResponseGetter::createResponse('false',E_BAD_REQUEST,'BAD REQUEST');
		}
	}
?>
