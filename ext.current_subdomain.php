<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * @package		current_subdomain
 * @subpackage	ThirdParty
 * @category	Extension
 * @author		@murtaugh
 * @link		
 */
class Current_subdomain_ext {

    var $settings        = array();
    
    var $name            = 'Current Subdomain';
    var $version         = '1.0';
    var $description     = 'Adds global variable {subdomain} based on current URL';
    var $settings_exist  = 'n';
    var $docs_url        = '';

    /**
     * Constructor 
     * 
     * @paramarray of settings
     */
    function Current_subdomain_ext($settings='')
    {
		$this->settings = $settings;						
		$this->EE =& get_instance();    	// Make a local reference to the ExpressionEngine super object							
    }
    
	/**
	 * Settings
	 */
	function settings()
	{

	}

	/**
	 * Update the extension
	 * 
	 * @param $current current version number
	 * @return boolean indicating whether or not the extension was updated 
	 */
	function update_extension($current='')
	{    
	    if ($current == '' OR $current == $this->version)
	    {
	        return FALSE;
	    }
	    
	    return FALSE;
	    // update code if version differs here
	}
		
	/**
	 * Disable the extention
	 * 
	 * @return unknown_type
	 */    
	function disable_extension()
	{		
		//
		// Remove added hooks
		//
		$this->EE->db->delete('extensions', array('class'=>get_class($this)));
	}
	
    /**
     * Activate the extension
     * 
     * This function is run on install and will register all hooks
     * 
     */
	function activate_extension()
	{
		 // -------------------------------------------------
		 // Register the hooks needed for this extension 
		 // -------------------------------------------------
		 
		$register_hooks = array(			
			// hook	=>	method
			'sessions_start' => 'sessions_start',				
		);
		
		foreach($register_hooks as $hook => $method)
		{
			$data = array(                                        
				'class'        => get_class($this),
				'method'       => $method,
				'hook'         => $hook,
				'settings'     => "",
				'priority'     => 10,
				'version'      => $this->version,
				'enabled'      => "y"
			);
			$this->EE->db->insert('extensions', $data); 	
		}
	}

	//
	// HOOKS
	//
	
	function sessions_start($ref)
	{
		$domain = $_SERVER['SERVER_NAME'];

		$this->EE->config->_global_vars['subdomain'] = array_shift((explode(".",$domain)));;
	}

}

/* End of file ext.extension.php */ 