<?php
	//echo 'OrderPageBuilder: '.$_SERVER["PHP_SELF"];
	class ProductRecipeResponseBuilder implements ResponseBuilder{
		public function build($request){
			$productIngredientDAO=new ProductIngredientDAO();
			if($_SERVER['REQUEST_METHOD'] === 'GET'){
				if(isset($_GET['productId']) && is_numeric($_GET['productId'])){
					$result=$productIngredientDAO->getAllIngredientByProductId($_GET['productId']);
					if(!empty($result)) return json_encode(array('status'=>true,'code'=>SUCCEED,'productRecipes'=>$result));
					else return ApiResponseGetter::createResponse('false',E_NO_PRODUCT_RECIPE,'NO PRODUCT RECIPE');
				}else{
				 	return ApiResponseGetter::createResponse('false',E_BAD_REQUEST,'NO PRODUCT ID INPUT');
				}
			}else{
				$request->body=json_decode(file_get_contents("php://input"));
				if(!isset($request->body->ingredients)){
					if(!isset($request->body->product_id)){
						return $this->createResponse('false',E_BAD_REQUEST,'NO PRODUCT ID INPUT');
					}
			  }
				//begin to add product recipe
				//set connect to disable autoclose on DAO
				$productIngredientDAO->connect();
				/* set autocommit to off */
				$productIngredientDAO->setAutoCommit(FALSE);
				$isTransactionPassed=true;
				foreach( $request->body->ingredients as $ingredient){
					//if have will edit
					if($productIngredientDAO->isIngredientExist($request->body->product_id,$ingredient->id)){
						if(!$productIngredientDAO->edit($request->body->product_id,$ingredient,$request->user_name)){
							 $isTransactionPassed=false;
							 break;
						 }
					}else{
						if(!$productIngredientDAO->create($request->body->product_id,$ingredient,$request->user_name)){
							 $isTransactionPassed=false;
							 break;
						 }
					}
				}
				$disableResult=$productIngredientDAO->disableIngredientNotIn($request->body->product_id,$request->body->ingredients,$request->user_name);
				if($disableResult === -1){
					return $this->rollBack($productIngredientDAO,'delete product recipe failed.');
				}
				if (!$isTransactionPassed) {
					return $this->rollBack($productIngredientDAO,'create product recipe failed.');
				}else{
					 $productIngredientDAO->commit();
					 $productIngredientDAO->close();
					 return ApiResponseGetter::createResponse("true",SUCCEED,count($request->body->ingredients));
				}
			}
		}
		public function rollBack($dao,$message){
			// Rollback transaction\n
			$dao->rollBack();
			/* close connection */
			$dao->close();
			return ApiResponseGetter::createResponse("false",E_MYSQL_QUERY_FAIL,$message);
		}
	}
?>
