<?php
	class ServerApiResponseGetter extends ResponseGetter{
		public function buildResponse($pageId,$request){
			switch ($request->pageId) {
	      case 'product':
	        $responseBuilder=new ProductResponseBuilder();
	        break;
	      default:
	        $responseBuilder=new ProductResponseBuilder();

	    }
	    echo $responseBuilder->build($request);
		}
	}
?>
