<?php

namespace XENONMC\XPFRAME\Mvc\mvc\view;

trait cache
{
    
    /**
     * cache a template
     * 
     * @param string $template name of the template to cache
     * @param string $group name of the group to get template from
     * @param bool $isLayout is the template a layout template
     * @return bool if the template was cached
     */
    public function cache(string $template, string $group, bool $isLayout = false): bool
    {
        // get the template
        $template_name = $template;
        $template = $this->compile($template, $group, $isLayout);
        
        $template_type_name = "templates";
        
        if ($isLayout == true) {
            $template_type_name = "layouts";
        }
        
        // create template path if not valid
        if (!file_exists($this->options["v-cache-dir"] . "/" . $group . "/" . $template_type_name)) {
            mkdir($this->options["v-cache-dir"] . "/" . $group . "/" . $template_type_name, 0777, true);
        }
        
        // make cache file
        file_put_contents($this->options["v-cache-dir"] . "/" . $group . "/" . $template_type_name . "/" . $template_name . ".php", $template);
        return true;
    }
    
    /**
     * reset a cache file
     * 
     * @param string $template name of the template to reset
     * @param string $group name of the group to reset template from
     * @param string $ifLayout is the template a layout template
     * @return bool if the template was reset
     */
    public function cache_reset(string $template, string $group, bool $isLayout = false): bool
    {
        try {
            // get template info
            $template_name = $template;
            $template_type_name = "templates";
            
            if ($isLayout == true) {
                $template_type_name = "layouts";
            }
            
            $template = $this->options["v-cache-dir"] . "/" . $group . "/" . $template_type_name . "/" . $template_name . ".php";
            
            // reset template
            unset($template);
        } catch(Exception $e) {
            // throw error and return false
            throw new Exception($e);
            return false;
        }
        
        return true;
    }
}