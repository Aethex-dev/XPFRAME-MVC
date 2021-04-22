<?php

namespace XENONMC\XPFRAME\Mvc\mvc;
use XENONMC\XPFRAME\Mvc\Mvc;

class View
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