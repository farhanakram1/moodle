<?php
/**
 * Invoices block
 */

class block_invoices extends block_base {

    public function init() {
        // $this->title = get_string('pluginname', 'block_invoices');
    }
    // The PHP tag and the curly bracket for the class definition 
    // will only be closed after there is another function added in the next section.

    public function get_content() {
	    
	    if ($this->content !== null) {
	      return $this->content;
	    }
	 
	    $this->content         =  new stdClass;
	    // $this->content->text   = 'The content of our Eodo Dashboard block!';
	    // $this->content->footer = 'Footer here...';
	 
	    return $this->content;
	}

	public function specialization() {
	    if (isset($this->config)) {
	        if (empty($this->config->title)) {
	            $this->title = get_string('blocksettings', 'block_invoices');            
	        } else {
	            $this->title = $this->config->title;
	        }
	 
	        if (empty($this->config->text)) {
	            $this->config->text = get_string('defaulttext', 'block_invoices');
	        }    
	    }
	}

	
    /**
     * Allow the block to have a configuration page
     */
    public function has_config() {
        return true;
    }


}