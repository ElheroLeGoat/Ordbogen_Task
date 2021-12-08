<?php
namespace controllers\helpers;

require_once __DIR__ .'/../../configs/definitions.php';

final class viewrender
{
    protected string $view;
    protected array $views = [];
    
    public function __construct()
    {
        $this->get_views();    
    }
    
    private function get_views()
    {
        $files = array_values(array_diff(scandir(VIEWS), [".", ".."]));        
        for ($x = 0; $x < count($files); $x++)
        {
            $this->views[rtrim($files[$x], '.php')] = $files[$x];
        }
    }
    
    public function render($data, $pass_as_api = False)
    {
        /**
         * Renders the requested view if found.
         * 
         * A simple Method used to render files from the views folder, if the view isn't found it'll default
         * to index.php if it's an API call the render will be a json page with the information requested.
         * 
         * @param string/array $view        - Either the view to be rendered or the data to be passed as an API
         * @param bool         $pass_as_api - Defaults to False used to render the page in JSON.
         * 
         * @since 1.0.2
         * @return None
         */
        if (!$pass_as_api)
        {
            try {
                include_once VIEWS . '/' . $this->views[$data];
                return;
            } catch (\Exception $e) {
                # Unable to render requested view Defaults to index.
                include_once VIEWS . '/index.php';
            }

        }
        
    }
}