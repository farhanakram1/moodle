<?php
/**
 * Accounts block
 */

class block_eodoo_dashboard extends block_base {

    public function init() {
        // $this->title = get_string('pluginname', 'block_eodoo_dashboard');
    }

    public function allcourse($allcourses){
        $array = [];
        foreach ($allcourses as $key => $value) {
            $row =  '<tr><td> '.$allcourses[$key]['fullname'].' </td></tr>';
            array_push($array, $row);
        }
        $string_version = implode(',', $array);
        return $string_version;
    }

    public function upload_course($upload_course){
      $array = [];
      foreach ($upload_course as $key => $value) {
         $row =  '<tr>
                      <td>'.$upload_course[$key]['name'].'</td>
                      <td>12</td>
                  </tr>';
         // $row =  '<tr>
         //              <td>'.$upload_course[$key]['fullname'].'</td>
         //          </tr>';
          array_push($array, $row);

      }
      $string_version = implode(',', $array);
       return $string_version;
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

        //Upload Tab
        $upload_course = $adminifos->upload_course();
        $uploadss = $this->upload_course($upload_course);
          // echo "<pre>";
          // print_r($uploadss);
          // die();
        //Upload Tab
        

        // Download Tab Word
        $allcourses = $adminifos->allcourses();
        $course_down = $this->allcourse($allcourses);
        // Download Tab Word
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
                                                <h1 class="text-center m-0 mb-3 px-md-3">Download Manager</h1>
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
                                                              <option>2</option>
                                                              <option>3</option>
                                                              <option>4</option>
                                                              <option>5</option>
                                                            </select>
                                                          </div>
                                                          <div class="form-group">
                                                            <select class="form-control" id="exampleFormControlSelect1" style="width: 61%;height: calc(2.5em + .75rem + 2px);border: 1px solid #9c9c9c !important;">
                                                              <option>Select course</option>
                                                              <option>2</option>
                                                              <option>3</option>
                                                              <option>4</option>
                                                              <option>5</option>
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
                                                              <tr>
                                                                <td>MR2020</td>
                                                                <td>Norwalk, James C</td>
                                                                <td>Course 1</td>
                                                                <td>JamesNorwalk_MR2020_Course1_Exam.pdf</td>
                                                                <td>25.5.2019</td>
                                                                <td>8</td>
                                                                <td>03.06.2019</td>
                                                              </tr>
                                                              <tr>
                                                                <td>MR2020</td>
                                                                <td></td>
                                                                <td>Course 2</td>
                                                                <td>JamesNorwalk_MR2020_Course2_Exam.pdf</td>
                                                                <td>25.5.2019</td>
                                                                <td>8</td>
                                                                <td>03.06.2019</td>
                                                              </tr>
                                                              <tr>
                                                                <td>BALI2019</td>
                                                                <td>Lee, Cathy</td>
                                                                <td>Course 1</td>
                                                                <td>LeeCathy_MR2020_Course1_Exam.pdf</td>
                                                                <td>25.5.2019</td>
                                                                <td>8</td>
                                                                <td>03.06.2019</td>
                                                              </tr>
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
                                                              <tr>
                                                                <td>MR2020</td>
                                                                <td>12</td>
                                                              </tr>
                                                              <tr>
                                                                <td>BALI2019</td>
                                                                <td>125</td>
                                                              </tr>
                                                              <tr>
                                                                <td>MR2019</td>
                                                                <td>40</td>
                                                              </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>

                                                    <div class="col-sm-6">
                                                        <form>
                                                          <div class="form-group">
                                                            <select class="form-control" id="exampleFormControlSelect1" style="width: 61%;height: calc(2.5em + .75rem + 2px);border: 1px solid #9c9c9c !important;">
                                                              <option>Select residency</option>
                                                              <option>2</option>
                                                              <option>3</option>
                                                              <option>4</option>
                                                              <option>5</option>
                                                            </select>
                                                          </div>
                                                          <div class="form-group">
                                                            <select class="form-control" id="exampleFormControlSelect1" style="width: 61%;height: calc(2.5em + .75rem + 2px);border: 1px solid #9c9c9c !important;">
                                                              <option>Select course</option>
                                                              <option>2</option>
                                                              <option>3</option>
                                                              <option>4</option>
                                                              <option>5</option>
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
                                                              <tr>
                                                                <td>Residency 2019</td>
                                                                <td>MR2019</td>
                                                              </tr>
                                                              <tr>
                                                                <td>Residency 2020</td>
                                                                <td>MR2020</td>
                                                              </tr>
                                                              <tr>
                                                                <td>Bali 2019</td>
                                                                <td>BALI2019</td>
                                                              </tr>
                                                              <tr>
                                                                <td>Residency 2021</td>
                                                                <td>MR2021</td>
                                                              </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>

                                                    <div class="col-sm-6">
                                                        <table class="table table-striped">
                                                            <thead>
                                                              <tr>
                                                                <th>Edit/Add Course</th>
                                                                <th>Code</th>
                                                              </tr>
                                                            </thead>
                                                            <tbody>
                                                              <tr>
                                                                <td>Course 1</td>
                                                                <td>EODO1241</td>
                                                              </tr>
                                                              <tr>
                                                                <td>Course 2</td>
                                                                <td>EODO1242</td>
                                                              </tr>
                                                              <tr>
                                                                <td>Course 3</td>
                                                                <td>EODO1244</td>
                                                              </tr>
                                                              <tr>
                                                                <td>Course 4</td>
                                                                <td>EODO1247</td>
                                                              </tr>
                                                              <tr>
                                                                <td>Course 5</td>
                                                                <td>EODO1251</td>
                                                              </tr>
                                                              <tr>
                                                                <td>Course 6</td>
                                                                <td>EODO1256</td>
                                                              </tr>
                                                              <tr>
                                                                <td>Course 7</td>
                                                                <td>EODO1262</td>
                                                              </tr>
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
                                                    
                                                    <div class="col-sm-6">
                                                        <table class="table table-striped">
                                                            <thead>
                                                              <tr>
                                                                <th>Residency</th>
                                                                <th>new</th>
                                                              </tr>
                                                            </thead>
                                                            <tbody>
                                                              <tr>
                                                                <td>MR2020</td>
                                                                <td>12</td>
                                                              </tr>
                                                              <tr>
                                                                <td>BALI2019</td>
                                                                <td>125</td>
                                                              </tr>
                                                              <tr>
                                                                <td>MR2019</td>
                                                                <td>40</td>
                                                              </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>

                                                    <div class="col-sm-6">
                                                        <form>
                                                          <div class="form-group">
                                                            <select class="form-control" id="exampleFormControlSelect1" style="width: 61%;height: calc(2.5em + .75rem + 2px);border: 1px solid #9c9c9c !important;">
                                                              <option>Select residency</option>
                                                              <option>2</option>
                                                              <option>3</option>
                                                              <option>4</option>
                                                              <option>5</option>
                                                            </select>
                                                          </div>
                                                          <div class="form-group">
                                                            <select class="form-control" id="exampleFormControlSelect1" style="width: 61%;height: calc(2.5em + .75rem + 2px);border: 1px solid #9c9c9c !important;">
                                                              <option>Select course</option>
                                                              <option>2</option>
                                                              <option>3</option>
                                                              <option>4</option>
                                                              <option>5</option>
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
                                                                <th>Invoice</th>
                                                                <th>Issued</th>
                                                                <th>Download</th>
                                                                <th>Resent</th>
                                                              </tr>
                                                            </thead>
                                                            <tbody>
                                                              <tr>
                                                                <td>MR2020</td>
                                                                <td>Norwalk, James C</td>
                                                                <td>Course 1</td>
                                                                <td>JamesNorwalk_MR2020_Course1_Exam.pdf</td>
                                                                <td>25.5.2019</td>
                                                                <td>8</td>
                                                                <td>03.06.2019</td>
                                                              </tr>
                                                              <tr>
                                                                <td>MR2020</td>
                                                                <td></td>
                                                                <td>Course 2</td>
                                                                <td>JamesNorwalk_MR2020_Course2_Exam.pdf</td>
                                                                <td>25.5.2019</td>
                                                                <td>8</td>
                                                                <td>03.06.2019</td>
                                                              </tr>
                                                              <tr>
                                                                <td>BALI2019</td>
                                                                <td>Lee, Cathy</td>
                                                                <td>Course 1</td>
                                                                <td>LeeCathy_MR2020_Course1_Exam.pdf</td>
                                                                <td>25.5.2019</td>
                                                                <td>8</td>
                                                                <td>03.06.2019</td>
                                                              </tr>
                                                            </tbody>
                                                          </table>
                                                    </div>
                                                  </div>

                                                  <button type="button" class="btn btn-primary float-right mt-2">Save</button>

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