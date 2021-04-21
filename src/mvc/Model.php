<?php

/**
 * COPYRIGHT XENONMC 2019 - Current
 *
 * XPFRAME and all of its named materials rights belong to XENONMC
 * You may fork and redistribute materials of this framework as long as proper crediting is given, learn more at https://xenonmc.xyz/resources/XENONMC/XPFRAME/copyright
 *
 * @package XENONMC\XPFRAME\Mvc\mvc
 * @author XENONMC <support@xenonmc.xyz>
 * @website https://xenonmc.xyz
 *
 */

namespace XENONMC\XPFRAME\Mvc\mvc;

use XENONMC\XPFRAME\Mvc\Mvc;

class Model
{

    /**
     * @var Mvc , mvc class object
     *
     */

    public Mvc $mvc;

    /**
     * mvc class used for sending and retrieving data from a [ Java Cassandra ] or [ MySQL ] database
     *
     * @param Mvc $mvc , mvc class object
     * @param array $options , array of all initialization options
     *
     */

    public function __construct(Mvc $mvc, array $options)
    {

        // store mvc class object
        $this->mvc = $mvc;
    }
}