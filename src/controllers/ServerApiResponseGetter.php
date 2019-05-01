<?php
	class ServerApiResponseGetter extends ResponseGetter{
		public function buildResponse($pageId,$request){
			switch ($pageId) {
	      case 'product':
	        $responseBuilder=new ProductResponseBuilder();
	        break;
				case 'ingredient':
	        $responseBuilder=new IngredientResponseBuilder();
	        break;
	      default:
					echo ServerApiResponseGetter::createResponse('false',E_BAD_REQUEST,'BAD REQUEST');
	        return;
	    }
	    $responseBuilder->build($request);
		}
	}
?>
