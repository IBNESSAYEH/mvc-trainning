<?php
//  url = controller/method/param[]
//Core class 
// routing class

class Core
{

    private $Controller = 'Pages';
    private $method = 'index';
    private $param = [];

    public function __construct()
    {

        $url = $this->getUrl();

        if (isset($url[0])) {
            if (file_exists('../app/controllers/' . ucwords($url[0]) . '.class.php')) {
                $this->Controller = ucwords($url[0]);
                unset($url[0]);
            }
        }

        //require the controller
        require_once '../app/controllers/' . $this->Controller . '.class.php';

        //instantiation of controller
        $this->Controller = new $this->Controller;

        if (isset($url[1])) {
            if (method_exists($this->Controller, $url[1])) {
                $this->method = $url[1];
                unset($url[1]);
            }
        }

        $this->param = $url ? array_values($url) : []; //ternary operator 

        //call the function
        call_user_func_array([$this->Controller, $this->method], $this->param);
    }

    public function getUrl()
    {

        if (isset($_GET['url'])) {

            $url = $_GET['url'];
            $url = filter_var($url, FILTER_SANITIZE_URL);
            $url = rtrim($url, '/');
            $url = explode('/', $url);

            return $url;
        }
    }
}
