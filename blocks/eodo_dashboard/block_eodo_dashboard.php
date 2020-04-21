<?php
/**
 * Eodo Dashboard block
 */

class block_eodo_dashboard extends block_base {

    public function init() {
        // $this->title = get_string('pluginname', 'block_eodo_dashboard');
    }
    // The PHP tag and the curly bracket for the class definition 
    // will only be closed after there is another function added in the next section.

    public function get_content() {
	    
	    if ($this->content !== null) {
	      return $this->content;
	    }
	 	
	 	$adminifos = new \theme_moove\util\admininfos();
	    $get_totalactiveusers = $adminifos->get_totalactiveusers();
	    $get_category_name = $adminifos->get_category_course_name();
	    $get_category_course_count_user = $adminifos->get_category_course_registered_user();
		
	    $this->content         =  new stdClass;
	    $this->content->text   = '<section id="region-main" class="cust-box-tab-admin" style="overflow-x: hidden;">    
            <div class="row">
                <div class="col-md-12 px-5">
                    <ul class="row nav nav-tabs {{#is_siteadmin}}remove_border{{/is_siteadmin}}" id="myTab" role="tablist">
                               
                        <li class="nav-item col-md-2 p-0 mr-0">
                            <a class="nav-item nav-link py-2 active" id="nav-overviews-tab" data-toggle="tab" href="#nav-overviews" role="tab" aria-controls="nav-overviews" aria-selected="true">Overview</a>
                        </li>
                               
                       <li class="nav-item col-md-2 p-0 mr-0">
                            <a class="nav-item nav-link py-2" id="nav-downloads-tab" data-toggle="tab" href="#nav-downloads" role="tab" aria-controls="nav-downloads" aria-selected="false">Downloads</a>
                        </li>

                        <li class="nav-item col-md-2 p-0 mr-0">
                            <a class="nav-item nav-link py-2" id="nav-uploads-tab" data-toggle="tab" href="#nav-uploads" role="tab" aria-controls="nav-uploads" aria-selected="false">Uploads</a>
                        </li>

                        <li class="nav-item col-md-2 p-0 mr-0">
                            <a class="nav-item nav-link py-2" id="nav-accounts-tab" data-toggle="tab" href="#nav-accounts" role="tab" aria-controls="nav-accounts" aria-selected="false">Accounts</a>
                        </li>

                        <li class="nav-item col-md-2 p-0 mr-0">
                            <a class="nav-item nav-link py-2" id="nav-codes-tab" data-toggle="tab" href="#nav-codes" role="tab" aria-controls="nav-codes" aria-selected="false">Codes</a>
                        </li>

                        <li class="nav-item col-md-2 p-0 mr-0">
                            <a class="nav-item nav-link py-2" id="nav-invoices-tab" data-toggle="tab" href="#nav-invoices" role="tab" aria-controls="nav-invoices" aria-selected="false">Invoices</a>
                        </li>
                    </ul>
                </div>
            </div>
        </section>';
	    $this->content->footer = '<section id="region-main" class="cust-box-tab" style="overflow-x: hidden;">
                    <div class="card mymaincontent">
                        <div class="row">
                            <div class="col-md-12" style="overflow:hidden;">
                                <div class="card-body cust-tabs-s-block">
                                    <div class="tab-content" id="mypublic-tab">

                                        <div class="tab-pane fade show active" id="nav-overviews" role="tabpanel" aria-labelledby="courses-tab">
                                            <table class="table table-striped">
                                                    <thead>
                                                      <tr>
                                                        <th>Add new residency</th>
                                                        <th>MR2020</th>
                                                        <th>BALI2019</th>
                                                        <th>MR2019</th>
                                                      </tr>
                                                    </thead>
                                                    <tbody>
                                                      <tr>
                                                        <th>Total registered</th>
                                                        <td>'.$get_totalactiveusers.'</td>
                                                        <td>5</td>
                                                        <td>5</td>
                                                      </tr>
                                                      <tr>
                                                        <th>Total submissions</th>
                                                        <td>5</td>
                                                        <td>50</td>
                                                        <td>5</td>
                                                      </tr>
                                                      <tr>
                                                        <th>Course 1</th>
                                                        <td>5</td>
                                                        <td>58</td>
                                                        <td>5</td>
                                                      </tr>
                                                      <tr>
                                                        <th>Course 2</th>
                                                        <td>5</td>
                                                        <td>60</td>
                                                        <td>5</td>
                                                      </tr>
                                                    </tbody>
                                                </table>
                                        </div>
                                            
                                        <div class="tab-pane fade" id="nav-downloads" role="tabpanel" aria-labelledby="nav-downloads-tab">
                                            <h1 class="text-left m-0 mb-3 px-md-3">Downloads</h1>
                                        </div>

                                        <div class="tab-pane fade" id="nav-downloads" role="tabpanel" aria-labelledby="nav-downloads-tab">
                                                <h1 class="text-left m-0 mb-3 px-md-3">Downloads</h1>
                                            </div>

                                            <div class="tab-pane fade" id="nav-uploads" role="tabpanel" aria-labelledby="nav-uploads-tab">
                                                <h1 class="text-left m-0 mb-3 px-md-3">Uploads</h1>
                                            </div>

                                            <div class="tab-pane fade" id="nav-accounts" role="tabpanel" aria-labelledby="nav-accounts-tab">
                                                <h1 class="text-left m-0 mb-3 px-md-3">Accounts</h1>
                                            </div>

                                            <div class="tab-pane fade" id="nav-codes" role="tabpanel" aria-labelledby="nav-codes-tab">
                                                <h1 class="text-left m-0 mb-3 px-md-3">Codes</h1>
                                            </div>

                                            <div class="tab-pane fade" id="nav-invoices" role="tabpanel" aria-labelledby="nav-invoices-tab">
                                                <h1 class="text-left m-0 mb-3 px-md-3">Invoices</h1>
                                            </div>

                                    </div>
                                </div>
                            </div>


                        </div>
                    </div>
                </section>';
	 
	    return $this->content;
	}

	public function specialization() {
	    if (isset($this->config)) {
	        if (empty($this->config->title)) {
	            $this->title = get_string('blocksettings', 'block_eodo_dashboard');            
	        } else {
	            $this->title = $this->config->title;
	        }
	 
	        if (empty($this->config->text)) {
	            $this->config->text = get_string('defaulttext', 'block_eodo_dashboard');
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