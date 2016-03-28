<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

/**
 * CodeIgniter Profiler Class
 *
 * This class enables you to display benchmark, query, and other data
 * in order to help with debugging and optimization.
 *
 * Note: At some point it would be good to move all the HTML in this class
 * into a set of template files in order to allow customization.
 *
 * @package CodeIgniter
 * @subpackage Libraries
 * @category Libraries
 * @author EllisLab Dev Team
 * @link http://codeigniter.com/user_guide/general/profiling.html
 */
class MY_Profiler extends CI_Profiler {

    // --------------------------------------------------------------------

    /**
     * Class constructor
     *
     * Initialize Profiler
     *
     * @param array $config
     */
    public function __construct($config = array()) {
        parent::__construct ();
    }

    // --------------------------------------------------------------------

}
