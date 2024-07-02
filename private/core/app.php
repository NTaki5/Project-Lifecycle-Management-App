<?php
class App
{

    protected $controller = 'Home';
    protected $method = 'index';
    protected $params = array();
    protected $projectsMenu = array();
    protected $tasksMenu = array();

    public function __construct()
    {
        date_default_timezone_set('Europe/Bucharest');
        $URL = $this->getUrl();
        // Search for Controller
        if (file_exists(CONTROLLERS_PATH . ucfirst($URL[0]) . ".php")) {
            $this->controller =  ucfirst($URL[0]);
            unset($URL[0]);

            require CONTROLLERS_PATH . $this->controller . ".php";
            $this->controller = new $this->controller(); //for example new Home()
        } else {
            require CONTROLLERS_PATH . "Error404.php";
            $this->controller = new Error404();
        }


        // Search for method inside
        if (isset($URL[1])) {
            if (method_exists($this->controller, $URL[1])) {
                $this->method = ucfirst($URL[1]);
                unset($URL[1]);
            }
        }

        //make a new array with all values from URL array (thats will be the remained params)
        // example if the url is HOST/projects/ai-category, then URL[0] = projects (the controller class), but I unset it above, and here
        // the URL[0] will be nothing and that's why I create a new array from remained values

        $URL = array_values($URL);
        $this->params = $URL;


        call_user_func_array([$this->controller, $this->method], $this->params);
    }

    private function getUrl()
    {
        // var_dump($_GET);
        // If not exist any GET parameter, return home page
        $GETurl = isset($_GET['url']) ? $_GET['url'] : "";

        $urlArr = strlen($GETurl) ? explode('/', filter_var(trim($GETurl, '/'), FILTER_SANITIZE_URL)) : ['home'];

        new SessionTimeout();
        if (Auth::is_logged_in()) {
            if ((strtolower($urlArr[0]) === 'login' || strtolower($urlArr[0]) === 'signup') && !isset($_GET['token'])) {
                return ['home'];
                
            }
            
        } else 
            if (strtolower($urlArr[0]) !== 'login' && strtolower($urlArr[0]) !== 'signup' && strtolower($urlArr[0]) !== 'passwordresets')
                header("Location: " . ROOT . "/login");

        if (strtolower($urlArr[0]) === 'signup' && isset($_GET['token']))
            Auth::logout();

        return $urlArr;
    }
}
