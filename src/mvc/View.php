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

class View
{

    /**
     * @var Mvc , mvc class object
     *
     */

    public Mvc $mvc;

    /**
     * mvc class used for displaying pages from a template, caching them rendering and more
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