<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/* Author: Jorge Torres
 * Description: Login controller class
 */
class Logout extends CRUD_Controller
{
    private $expire_hr;

    function __construct()
    {
        parent::__construct();
    }

    public function index($msg = NULL)
    {
        $this->destroy();
    }

    public function destroy()
    {
        $this->session->sess_destroy();
        redirect(site_url());
    }
}
