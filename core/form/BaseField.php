<?php
namespace app\core\form;
use app\core\Model;
abstract class BaseField{
  public Model $model;
  public string $attribute;

  abstract public function renderInput();

  public function __construct(Model $model,$attribute){
    $this->model= $model;
    $this->attribute= $attribute;
  }


  public function __toString(){
    return sprintf('
    <div class="mb-3">
      <label  class="form-label">%s</label>
      %s
      <div class="invalid-feedback">
       %s
      </div>
    </div>

    ',
     $this->model->labels()[$this->attribute] ?? $this->attribute,
     $this->renderInput(),
     $this->model->getFirstError($this->attribute)
     );
  }

}
 ?>
