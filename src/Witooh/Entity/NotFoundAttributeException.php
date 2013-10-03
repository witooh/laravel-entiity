<?php

namespace Witooh\Entity;


class NotFoundAttributeException extends \Exception {


    public function __construct($message = null, $code = 500)
    {
        parent::__construct($message ?: 'Attribute not found', $code);
    }
}