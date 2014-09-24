<?php

class UserController extends BaseController
{

    public function __construct()
    {
        parent::__construct();
        $this->mustBeLogedIn();

    }

}
