<?php

/**
 * A request Facade
 */
class Request
{

    /**
     * Input data
     *
     * @var string
     */
    public $input;

    public function __construct()
    {
        $this->input = array_merge($this->filter($_GET), $this->filter($_POST));
    }

    public function input($key, $default = null)
    {
        if (empty($key)) {
            return $this->input;
        }

        if (isset($this->input[$key])) {
            return $this->input[$key];
        }

        return $default;
    }

    public function exists($value)
    {
        return isset($this->input[$value]);
    }

    // Filters data against security risks.
    private function filter($data)
    {
        if (is_array($data)) {
            foreach ($data as $key => $element) {
                $data[$key] = $this->filter($element);
            }
        } else {
            $data = trim(htmlentities(strip_tags($data)));
            if (get_magic_quotes_gpc()) {
                $data = stripslashes($data);
            }
            $data = filter_var($data, FILTER_SANITIZE_STRING);
        }

        return $data;
    }
}
