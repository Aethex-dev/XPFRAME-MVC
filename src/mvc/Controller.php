<?php

namespace XENONMC\XPFRAME\vendor\Mvc\mvc;

use Exception;
use XENONMC\XPFRAME\vendor\Mvc\Mvc;

class Controller
{

    /**
     * @var Mvc mvc class object
     */
    public Mvc $mvc;

    /**
     * @var array array of all initialization options
     */
    public array $options;

    /**
     * controller class for mvc containing important functions to start stop and more for an application's class
     *
     * @param Mvc $mvc mvc class object
     * @param array $options array of all initialization options
     */
    public function __construct(Mvc $mvc, array $options)
    {
        // store mvc class object and options
        $this->mvc = $mvc;
        $this->options = $options;

        // configure dir config from options
        if (!file_exists($options["c-apps-dir"])) {
            mkdir($options["c-apps-dir"], 0777, true);
        }
    }

    /**
     * start an mvc application
     *
     * @param string $appName name of the app you want to start
     * @return bool if the app was started successfully
     * @throws Exception
     * @return bool if the app was started correctly
     */
    public function start(string $appName): bool
    {
        // import class if exists
        if (!file_exists($this->options["c-apps-dir"] . "/" . $appName . "/App.php")) {
            throw new Exception("Either the app name is invalid or there is no [ App.php ] file inside of the app directory");
        }
        return true;
    }
}