<?php

namespace KapitchiBase\Stdlib;

use ArrayObject;

class PluralField extends ArrayObject {
    
    public static function fromArray(array $data, $instance = null) {
        $pluralField = new self();
        
        foreach($data as $type => $values) {
            if(!array_key_exists('value', $values)) {
                throw new \Zend\Console\Exception\RuntimeException('value item is missing');
            }
            $value = $values['value'];
            
            if(!empty($values['type'])) {
                $type = $values['type'];
            }
            
            $primary = false;
            if(!empty($values['primary'])) {
                $primary = true;
            }
            
            $object = new ArrayObject(array(
                'type' => $type,
                'value' => $value,
                'primary' => $primary,
            ), ArrayObject::ARRAY_AS_PROPS);
            
            $pluralField->append($object);
        }
        
        return $pluralField;
    }
    
    
    private $primary = null;
    
    public function getPrimary() {
        //TODO
        throw new \RuntimeException("N/I");
        if($this->primary) {
            
        }
    }
    
}