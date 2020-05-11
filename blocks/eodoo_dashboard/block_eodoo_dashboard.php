<?php
/**
 * Accounts block
 */

class block_eodoo_dashboard extends block_base {

    public function init() {
        $this->title = get_string('pluginname', 'block_eodoo_dashboard');
    }
//Download Taps Functions
    public function allcourse($allcourses){
        $array = [];
        foreach ($allcourses as $key => $value) {
            $row =  '<tr><td> '.$allcourses[$key]['fullname'].' </td></tr>';
            array_push($array, $row);
        }
        $string_version = implode(',', $array);
        return $string_version;
    }
//Download Taps Functions
    
    // Upload tabs Functions

    public function upload_courses($upload_course){
      $array = [];
      foreach ($upload_course as $key => $value) {
         $row =  '<tr>
                      <td>'.$upload_course[$key]['name'].'</td>
                      <td>12</td>
                  </tr>';
          array_push($array, $row);
      }
      $string_version = implode(',', $array);
       return $string_version;
    }
    // select_cat
    public function select_cat($upload_course){
      $array = [];
      foreach ($upload_course as $key => $value) {
         $row =  '<option>'.$upload_course[$key]['name'].'</option>';
          array_push($array, $row);

      }
      $string_version = implode(',', $array);
       return $string_version;
    }
    // select_cat

    // select_course
    public function select_course($upload_course){
      $array = [];
      foreach ($upload_course as $key => $value) {
         $row =  '<option>'.$upload_course[$key]['fullname'].'</option>';
          array_push($array, $row);

      }
      $string_version = implode(',', $array);
       return $string_version;
    }
    // select_course

    // all_course_data
    public function all_course_data($upload_course){
      $array = [];
      foreach ($upload_course as $key => $value) {
         $row =  '<tr>
                    <td>'.$upload_course[$key]['name'].'</td>
                    <td>'.$upload_course[$key]['firstname'].'</td>
                    <td>'.$upload_course[$key]['fullname'].'</td>
                    <td>JamesNorwalk_MR2020_Course1_Exam.pdf</td>
                    <td>25.5.2019</td>
                    <td>8</td>
                    <td>03.06.2019</td>
                  </tr>';
          array_push($array, $row);

      }
      $string_version = implode(',', $array);
       return $string_version;
    }
    // select_course
 // Upload tabs Functions


    // Accounts tabs Functions
    
    public function upload_accountscourses($upload_course){
      $array = [];
      foreach ($upload_course as $key => $value) {
         $row =  '<tr>
                      <td>'.$upload_course[$key]['name'].'</td>
                      <td>'.count($upload_course[$key]['id']).'</td>
                  </tr>';
          array_push($array, $row);
      }
      $string_version = implode(',', $array);
       return $string_version;
    }
    // select_accountscat
    public function select_accountscat($upload_course){
      $array = [];
      foreach ($upload_course as $key => $value) {
         $row =  '<option>'.$upload_course[$key]['name'].'</option>';
          array_push($array, $row);

      }
      $string_version = implode(',', $array);
       return $string_version;
    }
    // select_accountscat

    // select_accountscourse
    public function select_accountscourse($upload_course){
      $array = [];
      foreach ($upload_course as $key => $value) {
         $row =  '<option>'.$upload_course[$key]['fullname'].'</option>';
          array_push($array, $row);

      }
      $string_version = implode(',', $array);
       return $string_version;
    }
    // select_accountscourse
 // Accounts tabs Functions

 // Codes tabs Functions
    public function code_category($codes){
      $array = [];
      foreach ($codes as $key => $value) {
         $row =  '<tr>
                    <td>'.$codes[$key]['name'].'</td>
                    <td>MR2019</td>
                  </tr>';
          array_push($array, $row);

      }
      $string_version = implode(',', $array);
       return $string_version;
    }

    public function code_courses($codes){
      $array = [];
      foreach ($codes as $key => $value) {
         $row =  '<tr>
                    <td>'.$codes[$key]['fullname'].'</td>
                    <td>'.$codes[$key]['shortname'].'</td>
                  </tr>';
          array_push($array, $row);

      }
      $string_version = implode(',', $array);
       return $string_version;
    }
 // Codes tabs Functions
 
 // invoices tabs Functions

    public function invoices_cat($invoices){
      $array = [];
      foreach ($invoices as $key => $value) {
         $row =  '<tr>
                    <td>'.$invoices[$key]['firstname'].'</td>
                    <td>'.$invoices[$key]['lastname'].'</td>
                    <td>'.$invoices[$key]['user_email'].'</td>
                    <td>'.$invoices[$key]['discount_code'].'</td>
                  </tr>';
          array_push($array, $row);

      }
      $string_version = implode(',', $array);
       return $string_version;
    }

    // public function select_invoice_cat($invoices){
    //   $array = [];
    //   foreach ($invoices as $key => $value) {
    //      $row =  '<option>'.$invoices[$key]['name'].'</option>';
    //       array_push($array, $row);

    //   }
    //   $string_version = implode(',', $array);
    //    return $string_version;
    // }

    // public function select_invoice_course($invoices){
    //   $array = [];
    //   foreach ($invoices as $key => $value) {
    //      $row =  '<option>'.$invoices[$key]['fullname'].'</option>';
    //       array_push($array, $row);

    //   }
    //   $string_version = implode(',', $array);
    //    return $string_version;
    // }

    // public function invoice_course_data($invoices){
    //   $array = [];
    //   foreach ($invoices as $key => $value) {
    //      $row =  '<tr>
    //                 <td>'.$invoices[$key]['name'].'</td>
    //                 <td>'.$invoices[$key]['firstname'].'</td>
    //                 <td>'.$invoices[$key]['fullname'].'</td>
    //                 <td>JamesNorwalk_MR2020_Course1_Exam.pdf</td>
    //                 <td>25.5.2019</td>
    //                 <td>8</td>
    //                 <td>03.06.2019</td>
    //               </tr>';
    //       array_push($array, $row);

    //   }
    //   $string_version = implode(',', $array);
    //    return $string_version;
    // }

 // invoices tabs Functions

 // Course External Link Function

    public function external_link($course_external_link){
      $array = [];
      foreach ($course_external_link as $key => $value) {
         $row =  '<tr>
                    <td>'.$course_external_link[$key]['category_id'].'</td>
                    <td>'.$course_external_link[$key]['name'].'</td>
                    <td><a href="'.$course_external_link[$key]['external_link'].'" target="_blank">'.$course_external_link[$key]['external_link'].'</a></td>
                    <td><a href="" class="btn btn-xs btn-default"><i class="fa fa-edit"></i></a></td>
                  </tr>';
          array_push($array, $row);

      }
      $string_version = implode(',', $array);
       return $string_version;
    }

 // Course External Link Function


    // The PHP tag and the curly bracket for the class definition 
    // will only be closed after there is another function added in the next section.

    public function get_content() {
	    
	    if ($this->content !== null) {
	      return $this->content;
	    }
	 
	    $adminifos = new \theme_moove\util\admininfos();
	    $get_totalactiveusers = $adminifos->get_totalactiveusers();
	    $get_category_name = $adminifos->get_category_course_name();

        //Upload Tab
        $upload_course = $adminifos->upload_course();
        $uploadss = $this->upload_courses($upload_course);
        $select_cat = $this->select_cat($upload_course);
        $select_course = $this->select_course($upload_course);
        $all_course_data = $this->all_course_data($upload_course);
        //Upload Tab

        //Account Tab
        $accounts = $adminifos->accounts();
        $upload_accountscourses = $this->upload_accountscourses($accounts);
        $select_accountscat = $this->select_accountscat($accounts);
        $select_accountscourse = $this->select_accountscourse($accounts);
        //Account Tab

        //Codes Tab
        $codes = $adminifos->codes();
        $code_category = $this->code_category($codes);
        $code_courses = $this->code_courses($codes);
        //Codes Tab

        //invoices Tab
        $invoices = $adminifos->invoices();
        $invoices_cat = $this->invoices_cat($invoices);
        // $select_invoice_cat = $this->select_invoice_cat($invoices);
        // $select_invoice_course = $this->select_invoice_course($invoices);
        // $invoice_course_data = $this->invoice_course_data($invoices);
        // echo "<pre>";
          // print_r($invoices);
          // die();
        //invoices Tab
        

        // Download Tab Word
        $allcourses = $adminifos->allcourses();
        $course_down = $this->allcourse($allcourses);
        // Download Tab Word

        // Course External Link
        $course_external_link = $adminifos->course_external_link();
        $external_link = $this->external_link($course_external_link);
        // Course External Link.
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

                        <li class="nav-item col-md-2 p-0 mr-0">
                            <a class="nav-item nav-link py-2" id="nav-external-links-tab" data-toggle="tab" href="#nav-external-links" role="tab" aria-controls="nav-external-links" aria-selected="false">Course External Links</a>
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
                                                <div class="container">           
                                                  <table class="table table-striped">
                                                    <thead>
                                                      <tr>
                                                        <th></th>
                                                        <th></th>
                                                        <th></th>
                                                      </tr>
                                                    </thead>
                                                    <tbody>
                                                      '.$course_down.'
                                                    </tbody>
                                                  </table>
                                                </div>

                                            </div>


                                            <div class="tab-pane fade" id="nav-uploads" role="tabpanel" aria-labelledby="nav-uploads-tab">
                                                <div class="container">
                                                  <div class="row">
                                                    
                                                    <div class="col-sm-6">
                                                        <table class="table table-striped">
                                                          <thead>
                                                            <tr>
                                                              <th>Residency</th>
                                                              <th>Pending</th>
                                                            </tr>
                                                          </thead>
                                                          <tbody>'                                                            
                                                        .$uploadss.

                                                        '</tbody>
                                                        </table>
                                                    </div>

                                                    <div class="col-sm-6">
                                                        <form>
                                                          <div class="form-group">
                                                            <select class="form-control" id="exampleFormControlSelect1" style="width: 61%;height: calc(2.5em + .75rem + 2px);border: 1px solid #9c9c9c !important;">
                                                              <option>Select residency</option>
                                                             '.$select_cat.'
                                                            </select>
                                                          </div>
                                                          <div class="form-group">
                                                            <select class="form-control" id="exampleFormControlSelect1" style="width: 61%;height: calc(2.5em + .75rem + 2px);border: 1px solid #9c9c9c !important;">
                                                              <option>Select course</option>
                                                              '.$select_course.'
                                                            </select>
                                                          </div>
                                                        </form>
                                                    </div>

                                                  </div>
                                                  <br><br>
                                                  <div class="row">
                                                    <div class="col-sm-12">
                                                        <table class="table table-striped table-responsive">
                                                            <thead>
                                                              <tr>
                                                                <th>Residency</th>
                                                                <th>Name</th>
                                                                <th>Course</th>
                                                                <th>Files</th>
                                                                <th>Uploaded on</th>
                                                                <th>Days since submission</th>
                                                                <th>Corrected on</th>
                                                              </tr>
                                                            </thead>
                                                            <tbody>
                                                              '.$all_course_data.'
                                                            </tbody>
                                                          </table>
                                                    </div>
                                                  </div>

                                                  <button type="button" class="btn btn-primary float-right mt-2">Save</button>

                                                </div>
                                            </div>


                                            <div class="tab-pane fade" id="nav-accounts" role="tabpanel" aria-labelledby="nav-accounts-tab">

                                                <div class="container">
                                                  <div class="row">
                                                    
                                                    <div class="col-sm-6">
                                                        <table class="table table-striped">
                                                            <thead>
                                                              <tr>
                                                                <th>Residency</th>
                                                                <th>Registered</th>
                                                              </tr>
                                                            </thead>
                                                            <tbody>
                                                              '.$upload_accountscourses.'
                                                            </tbody>
                                                        </table>
                                                    </div>

                                                    <div class="col-sm-6">
                                                        <form>
                                                          <div class="form-group">
                                                            <select class="form-control" id="exampleFormControlSelect1" style="width: 61%;height: calc(2.5em + .75rem + 2px);border: 1px solid #9c9c9c !important;">
                                                              <option>Select residency</option>
                                                              '.$select_accountscat.'
                                                            </select>
                                                          </div>
                                                          <div class="form-group">
                                                            <select class="form-control" id="exampleFormControlSelect1" style="width: 61%;height: calc(2.5em + .75rem + 2px);border: 1px solid #9c9c9c !important;">
                                                              <option>Select course</option>
                                                              '.$select_accountscourse.'
                                                            </select>
                                                          </div>
                                                        </form>
                                                    </div>

                                                  </div>
                                                  
                                                </div>
                                            </div>


                                            <div class="tab-pane fade" id="nav-codes" role="tabpanel" aria-labelledby="nav-codes-tab">
                                                
                                              <div class="container">
                                                  <div class="row">
                                                    <div class="col-sm-6">
                                                        <table class="table table-striped">
                                                            <thead>
                                                              <tr>
                                                                <th>Edit/Add Residency</th>
                                                                <th>Reg. Code</th>
                                                              </tr>
                                                            </thead>
                                                            <tbody>
                                                              '.$code_category.'
                                                            </tbody>
                                                        </table>
                                                    </div>

                                                    <div class="col-sm-6">
                                                        <table class="table table-striped table-responsive">
                                                            <thead>
                                                              <tr>
                                                                <th>Edit/Add Course</th>
                                                                <th>Code</th>
                                                              </tr>
                                                            </thead>
                                                            <tbody>
                                                              '.$code_courses.'
                                                            </tbody>
                                                        </table>
                                                    </div>

                                                  </div>
                                                </div>
                                                <button type="button" class="btn btn-primary float-right mt-2">Save</button>  

                                            </div>


                                            <div class="tab-pane fade" id="nav-invoices" role="tabpanel" aria-labelledby="nav-invoices-tab">
                                                

                                              <div class="container">
                                                  <div class="row">
                                                    
                                                    <div class="col-sm-12">
                                                        <table class="table table-striped">
                                                            <thead>
                                                              <tr>
                                                                <th>First Name</th>
                                                                <th>Last Name</th>
                                                                <th>User Email</th>
                                                                <th>Discount Code</th>
                                                              </tr>
                                                            </thead>
                                                            <tbody>
                                                              '.$invoices_cat.'
                                                            </tbody>
                                                        </table>
                                                    </div>


                                                  </div>
                                                  

                                                </div>
                                                
                                            </div>



                                            <div class="tab-pane fade" id="nav-external-links" role="tabpanel" aria-labelledby="nav-external-links-tab">

                                              <div class="container">
                                                <form class="form-inline" action="">
                                                  <div class="form-group">
                                                    <input type="text" class="form-control" id="external_link" placeholder="Course External Link" name="external_link">
                                                  </div>
                                                  <button type="submit" class="btn btn-default">Save</button>
                                                </form>
                                                <div class="row">
                                                  <div class="col-sm-12">
                                                      <table class="table table-striped">
                                                          <thead>
                                                            <tr>
                                                              <th>Category ID</th>
                                                              <th>Category Name</th>
                                                              <th>Course External Links</th>
                                                              <th>Action</th>
                                                            </tr>
                                                          </thead>
                                                          <tbody>
                                                            '.$external_link.'
                                                          </tbody>
                                                      </table>
                                                  </div>
                                                </div>
                                              </div>
                                                
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
	            $this->title = get_string('blocksettings', 'block_eodoo_dashboard');            
	        } else {
	            $this->title = $this->config->title;
	        }
	 
	        if (empty($this->config->text)) {
	            $this->config->text = get_string('defaulttext', 'block_eodoo_dashboard');
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