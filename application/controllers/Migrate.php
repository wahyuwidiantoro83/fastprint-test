<?php

class Migrate extends CI_Controller
{
        public function index()
        {
                $this->load->library('migration');

                if ($this->migration->current() === FALSE)
                {
                    show_error($this->migration->error_string());
                } else {
                    echo "<h1>Migration Table Success</h1><a href='http://localhost/fastprint/API/get-data'>Get data from API</a><span> or </span><a href='http://localhost/fastprint/'>Back to Home</a>";
                }
        }
}