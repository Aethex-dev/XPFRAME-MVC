<?php

namespace XENONMC\XPFRAME\Mvc\mvc;
use XENONMC\XPFRAME\Mvc\Mvc;
use XENONMC\XPFRAME\Mvc\mvc\view\TwigInit;
use Twig\Environment;
use XENONMC\XPFRAME\Mvc\mvc\view\cache;

class View
{

    /**
     * @var Mvc mvc class object
     */
    public Mvc $mvc;
    
    /**
     * @var Environment twig object
     */
    public Environment $twig;
    
    /**
     * @var array options used for initialization
     */
    public array $options;
    
    /**
     * cache functions
     */
    use cache;

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
        
        // create storage dirs
        if (!file_exists($options["v-cache-dir"])) {
            mkdir($options["v-cache-dir"], 0777, true);
        }
        
        if (!file_exists($options['v-views-dir'])) {
            mkdir($options["v-views-dir"], 0777, true);
        }
        
        // initialize twig with initializer
        $twig_init = new TwigInit($options);
        $this->twig = $twig_init->get_twig();
    }
    
    /**
     * compile a template
     * 
     * @param string $group name of the group to get template from
     * @param string $template name of the template to compile
     * @param bool $isLayout is the template a layout template
     * @return string php template
     */
    public function compile(string $template, string $group, bool $isLayout): string
    {
        
        // get the template path
        $template_type_name = "templates";
        
        if ($isLayout == true) {
            $template_type_name = "layouts";
        }
        
        $template_path = $this->options["v-views-dir"] . "/" . $group . "/" . $template_type_name . "/" . $template . ".twig";
        
        // compile template to php code
        return $this->twig->compileSource($this->twig->getLoader()->getSourceContext($template_path));
    }
    
    /**
     * get a rendered template
     * 
     * @param string $template name of the template to render
     * @param string $group group name of were the template is located
     * @param bool $isLayout is the template a layout template
     * @param bool $fromCache get the template from cache
     * @return string executed template string
     */
    public function get_rendered_template(string $template, string $group, bool $isLayout = false, bool $fromCache = true): string
    {
        // get the template
        $template_type_dir = "templates";
        
        if ($isLayout == true) {
            $template_type_dir = "layouts";
        }
        
        if ($fromCache == true) {
            
            // execute and return the the template
            $template = file_get_contents($this->options["v-cache-dir"] . "/" . $group . "/" . $template_type_dir . "/" . $template . ".php");
            eval("?>" . $template);
            
            $template_class = preg_match($template, "class (.+?)");
            $template = new $template_class;
            
            $template = $template->render([]);
            return $template;
        } else {
            
            // compile and return the template
            $template = $this->compile($template, $group, $isLayout);
            eval("?>" . $template);
            
            preg_match("~class (.+?) ~", $template, $template_class);
            $template_class = $template_class[1];
            $template = new $template_class($this->twig);
            
            $template = $template->render([]);
            return $template;
        }
    }
}