<?php
	class ServerApiResponseGetter extends ResponseGetter{
		public function buildResponse($pageId,$request){
			switch ($pageId) {
	      case 'product':
	        $responseBuilder=new ProductResponseBuilder();
	        break;
				case 'productRecipe':
	        $responseBuilder=new ProductRecipeResponseBuilder();
	        break;
				case 'restaurantProduct':
	        $responseBuilder=new RestaurantProductResponseBuilder();
	        break;
				case 'ingredient':
	        $responseBuilder=new IngredientResponseBuilder();
	        break;
				case 'restaurantIngredient':
	        $responseBuilder=new RestaurantIngredientResponseBuilder();
	        break;
	      default:
					return ServerApiResponseGetter::createResponse('false',E_BAD_REQUEST,'BAD REQUEST');
	    }
	    return $responseBuilder->build($request);
		}
	}
?>
