<?php
class ProductIngredientDAO extends BaseDAO{
  function __construct(){
     parent::__construct("product_ingredient");
  }
  function getAllIngredientByProductId($productId){
    return $this->getAllQuery('SELECT i.id,i.name,i.description,i.image,i.reference_price,u.name as unit_name,pi.count FROM product_ingredient pi LEFT JOIN ingredient i ON i.id=pi.ingredient_id LEFT JOIN unit u ON u.id=i.unit_id WHERE pi.available=1 AND product_id='.$productId);
  }
  function isIngredientExist($productId,$ingredientId){
    return $this->getOnceWhere('product_id='.$productId.' AND ingredient_id='.$ingredientId)!==NULL;
  }
  function create($productId,$ingredient,$requester){
    $sql='INSERT INTO '.$this->getTableName();
    $sql.='(product_id, ingredient_id, count, available, creator, created_date, updater, last_updated_date)';
    $sql.='VALUES(';
    $sql.=$productId.', ';
    $sql.=$ingredient->id.', ';
    $sql.=$ingredient->count.', ';
    $sql.='1, ';
    $sql.='\''.$requester.'\', now(), ';
    $sql.='\''.$requester.'\', now());';

    if(isset($this->connection)){
      return $this->queryNotAutoClose($sql);
    }else{
      return $this->query($sql);
    }
  }
  function edit($productId,$ingredient,$requester){
    $sql='UPDATE '.$this->getTableName().' SET ';
    $sql.='count='.$ingredient->count.', ';
    $sql.='available=1, ';
    $sql.='updater=\''.$requester.'\', last_updated_date=now()';
    $sql.=' WHERE product_id='.$productId.' AND ingredient_id='.$ingredient->id;
    if(isset($this->connection)){
      return $this->queryNotAutoClose($sql);
    }else{
      return $this->query($sql);
    }
  }
  //return number recipe are enabled
  function disableIngredientNotIn($productId,$ingredients,$requester){//if put connection mean transaction
    $notInList='';
    $count=0;
    foreach( $ingredients as $ingredient){
      if(isset($ingredient->id)){//has id to disable
        $count++;
        if(empty($notInList)) {
          $notInList.='('.$ingredient->id;
        }else{
          $notInList.=','.$ingredient->id;
        }
      }
    }
    if(!empty($notInList)) {
      $notInList.=')';
      $sql='UPDATE '.$this->getTableName().' SET available=0 WHERE product_id='.$productId.' AND (ingredient_id NOT IN '.$notInList.')';
    }else{
      $sql='UPDATE '.$this->getTableName().' SET available=0 WHERE product_id='.$productId;
    }
    if(isset($this->connection)){
      if($this->queryNotAutoClose($sql)) return $count;
      else return -1;
    }else{
      if($this->query($sql)) return $count;
      else return -1;
    }
  }
}
?>
