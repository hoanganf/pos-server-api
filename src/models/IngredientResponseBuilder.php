<?php
	//echo 'OrderPageBuilder: '.$_SERVER["PHP_SELF"];
	class IngredientResponseBuilder implements ResponseBuilder{
		public function build($request){
			$adapter=new IngredientDAO();
			if(isset($_GET['categoryId']) && is_numeric($_GET['categoryId'])){
				$ingredients=$adapter->getIngredientsByCategoryId($_GET['categoryId']);
				if(!empty($ingredients)) echo json_encode(array('status'=>true,'code'=>SUCCEED,'ingredients'=>$ingredients),true);
				else echo ServerApiResponseGetter::createResponse('false',E_NO_INGREDIENT,'NO INGREDIENT');
			}else if(isset($_GET['ingredientId']) && is_numeric($_GET['ingredientId'])){
				$ingredient=$adapter->getIngredient($_GET['ingredientId']);
				if($ingredient!==null) echo json_encode(array('status'=>true,'code'=>SUCCEED,'ingredient'=>$ingredient),true);
				else echo ServerApiResponseGetter::createResponse('false',E_NO_INGREDIENT,'NO INGREDIENT');
			}else{
				$ingredients=$adapter->getAll();
				if(!empty($ingredients)) echo json_encode(array('status'=>true,'code'=>SUCCEED,'ingredients'=>$ingredients),true);
				else echo ServerApiResponseGetter::createResponse('false',E_NO_INGREDIENT,'NO INGREDIENT');
			}
		}
	}
?>
