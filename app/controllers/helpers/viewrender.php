<?php
/**
 * @todo Finish up the viewrender
 * 
 * Rendering of views should be 100% dynamic with ease.
 * in the viewrenders current state it relies on a director (render.php)
 * Also a router would function great with this type of setup.
 */

namespace controllers\helpers;

require_once __DIR__ .'/../../configs/definitions.php';


/**
 * A strict Viewrender used to find and render the current view.
 * 
 * @author ElHeroLeGoat
 * @version 1.0.0
 */
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
        /**
         * gets the views from the view folder.
         * 
         * This method will retrieve any view located in the views folder.
         * 
         * @todo When modules/plugins is going to be introduced the get_views needs to take that into account.
         * 
         * @return Null
         * 
         * @since 1.0.0
         */
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
         * @return None
         * 
         * @since 1.0.0
         */
        if (!$pass_as_api)
        {
            $pass_to_file = $data["pass"];
            try {
                include_once VIEWS . '/' . $this->views[$data["view"]];
                return;
            } catch (\Exception $e) {
                # Unable to render requested view Defaults to index.
                include_once VIEWS . '/index.php';
            }

        }
        else
        {
            header('content-type:application/json');
            echo json_encode($data);
        }
        
    }
}