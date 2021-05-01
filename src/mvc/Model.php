<?php

namespace XENONMC\XPFRAME\vendor\Mvc\mvc;

use XENONMC\XPFRAME\vendor\Mvc\Mvc;

class Model
{

    /**
     * @var Mvc mvc class object
     */
    public Mvc $mvc;

    /**
     * controller class for mvc containing important functions to start stop and more for an application's class
     *
     * @param Mvc $mvc mvc class object
     * @param array $options array of all initialization options
     */
    public function __construct(Mvc $mvc, array $options)
    {
        // store mvc class object
        $this->mvc = $mvc;
    }
}