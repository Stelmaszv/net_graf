<?php

namespace App\Api;

use Exception;
use App\DB\DBInterface;
use App\Validators\Validators;
use App\Validators\EmailValidator;

abstract class AbstractAction{

    protected DBInterface $engin;
    protected ?int $id;
    protected ?string $method;
    protected ?array $data;
    protected array $errors = [];

    function __construct(DBInterface $engin, int $id = null, array $data = null)
    {
        $this->engin = $engin;
        if($this->method !== "GET"){
            $this->fieldValidation($data);
        }
        $this->data = $data;

        if($_SERVER['REQUEST_METHOD'] !== $this->method){
            throw new Exception('Invalid Http method !');
        }

        $this->id = intval($id);
    }

    private function validate(): void
    {
        foreach($this->setValidationRouls() as $key => $roule){
            $fieldValidators = explode(' | ' , $roule);
            foreach($fieldValidators as $validator){
                $validator = Validators::getValidator($validator);

                $validator->setValue($this->data[$key]);
                $validatorMessage = $validator->validate();

                if($validatorMessage){
                    $this->errors[] = [
                        "Collumn" => $key,
                        "message" => $validatorMessage,
                    ];
                } 

            }
        }
    }

    protected function setValidationRouls() : array 
    { 
        return []; 
    }

    protected function getColumns(){
        return array_map(function(array $elemnt) {
            return $elemnt['column_name'];
        }, $this->engin->getQueryLoop("SELECT column_name FROM information_schema.columns WHERE table_name = 'product';"));
    }

    private function fieldValidation(array $data){
        
        foreach(array_keys($data) as $column){
            if(!in_array($column,$this->getColumns())){
                $this->errors[] = [
                    "Collumn" => $column,
                    "message" => "Collumn '$column' not exist !",
                ];
            }  
        }

        return $this->errors;
    }

    public function getAction(){
        $this->validate();

        if(count($this->errors) > 0){
            return json_encode($this->errors);
        }

        return $this->action();
    }

    abstract public function action();
}