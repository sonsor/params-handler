<?php

class ParamsHandler
{
    /**
    * @type array
    * use to store $_POST parameters
    */
    private $_post;

    /**
    * @type array
    * use to store $_GET parameters
    */
    private $_get;

    /**
    * @type array
    * use to store $_REQUEST parameters
    */
    private $_files;

    /**
    * @type array
    * use to store $_FILES parameters
    */
    private $_params;

    /**
    * contructor
    * @return void
    */
    public function __construct()
    {
        $this->_post = array();
        $this->_get = array();
        $this->_files = array();
        $this->_params = array();

        $this->setPost($_POST);
        $this->setGet($_GET);
        $this->setParams($_GET, $_POST);
        $this->setFiles($_FILES);
    }

    /**
    * @param array $post the post parameters
    * @return void
    */
    private function setPost($post)
    {
        $this->_post = $post;
    }

    /**
    * @param array $get the url parameters
    * @return void
    */
    private function setGet($get)
    {
        $this->_get = $get;
    }

    /**
    * @param array $get the get parameters
    * @param array $post the post parameters
    * @return void
    */
    private function setParams($get, $post)
    {
        $this->_params = array_merge($_GET, $_POST);
    }

    /**
    * @param array $file the files parameters
    * @return void
    */
    private function setFiles($files)
    {
        if (!is_array($files)) return;
        if (count($files) === 0) return;

        foreach ($files as $k => $file) {   
            $isMultiple = false;
            if (is_array($file['name'])) $isMultiple = true;
            
            if ($isMultiple) {
                $total = count($file['name']);
                for ($i = 0; $i < $total; $i++) {
                    $keys = array_keys($file);
                    foreach ($keys as $key) {
                        $this->_files[$k][$i][$key] = $file[$key][$i];
                    }
                }
            } else {
                $this->_files[$k] = $file;
            }
        }
    }

    /**
    * @param string $key to get specific post paramter
    @ @param mixed $default use to default value if paramter is not set
    * @return mixed
    */
    public function post($key, $default = false)
    {
        if (empty($key)) throw new Exception('Invalid parameter index');
        if (isset($this->_post[$key])) {
            return $this->_post[$key];
        }

        return $default;
    }

    /**
    * @param string $key to get specific url paramter
    @ @param mixed $default use to default value if paramter is not set
    * @return mixed
    */
    public function get($key, $default = false)
    {
        if (empty($key)) throw new Exception('Invalid parameter index');
        if (isset($this->_get[$key])) {
            return $this->_get[$key];
        }

        return $default;
    }
    
    /**
    * @param string $key to get specific uploaded file paramter
    @ @param mixed $default use to default value if paramter is not set
    * @return mixed
    */
    public function file($key, $default = false)
    {
        if (empty($key)) throw new Exception('Invalid parameter index');
        if (isset($this->_files[$key])) {
            return $this->_files[$key];
        }

        return $default;
    }

    /**
    * @param string $key to get specific get or post paramter
    @ @param mixed $default use to default value if paramter is not set
    * @return mixed
    */
    public function params($key, $default = false)
    {
        if (empty($key)) throw new Exception('Invalid parameter index');
        if (isset($this->_params[$key])) {
            return $this->_params[$key];
        }

        return $default;
    }
}
