<?php

namespace KapitchiContact\Service;

class Contact {
    public function persist($params) {
        if(empty($params['data'])) {
            throw new \InvalidArgumentException("data needed");
        }
        
        var_dump($params);
        exit;
    }
}