<?php

namespace KapitchiContact\Model;

/**
 * Let's try to be as much compatible with OpenSocial as possible.
 * http://opensocial-resources.googlecode.com/svn/spec/2.0.1/Social-Data.xml#Name
 */
class Name extends \ZfcBase\Model\ModelAbstract {
    protected $formatted;
    protected $givenName;
    protected $middleName;
    protected $familyName;
    protected $honorificPrefix;
    protected $honorificSuffix;
}