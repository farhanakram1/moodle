<?php

/**
 * Accounts block
 */
include 'includes/tabs.php';

class block_eodoo_dashboard extends block_base {

    public function init() {
        $this->title = get_string('pluginname', 'block_eodoo_dashboard');
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
    // public function form_custom_link(){
    //    global $DB, $data;
    //   $external_ = '<form class="form-inline" action="">
    //                   <div class="form-group">
    //                     <input type="text" class="form-control" id="external_link" placeholder="Course External Link" name="external_link">
    //                   </div>
    //                   <button type="submit" class="btn btn-md btn-default">Save</button>
    //                 </form>';
    //   // $data = new stdClass();
    //   // echo "<pre>";
    //   // print_r($data);
    //   // die();           
    //   return $external_;  
    // }
    // Course External Link Function
    // The PHP tag and the curly bracket for the class definition 
    // will only be closed after there is another function added in the next section.

    public function get_content() {

        if ($this->content !== null) {
            return $this->content;
        }
        if (!is_siteadmin()) {
            return;
        }

        $adminifos = new \theme_moove\util\admininfos();
        $get_totalactiveusers = $adminifos->get_totalactiveusers();
        $get_category_name = $adminifos->get_category_course_name();
        $tabs = new Tabs;
        //Upload Tab
        $upload_course = $adminifos->upload_course();
        $uploadss = $tabs->upload_courses($upload_course);
        $select_cat = $tabs->select_cat($upload_course);
        $select_course = $tabs->select_course($upload_course);
        $all_course_data = $tabs->all_course_data($upload_course);
        //Upload Tab
        //Account Tab
        $accounts = $adminifos->accounts();
        $upload_accountscourses = $tabs->upload_accountscourses($accounts);
        $select_accountscat = $tabs->select_accountscat($accounts);
        $select_accountscourse = $tabs->select_accountscourse($accounts);
        //Account Tab
        //Codes Tab
        $codes = $adminifos->codes();
        $code_category = $tabs->code_category($codes);
        $code_courses = $tabs->code_courses($codes);
        //Codes Tab
        //invoices Tab
        $invoices = $adminifos->invoices();
        $invoices_cat = $tabs->invoices_cat($invoices);
        // $select_invoice_cat = $this->select_invoice_cat($invoices);
        // $select_invoice_course = $this->select_invoice_course($invoices);
        // $invoice_course_data = $this->invoice_course_data($invoices);
        // echo "<pre>";
        // print_r($invoices);
        // die();
        //invoices Tab
        // Download Tab Word
        $allcourses = $adminifos->allcourses();
        $course_down = $tabs->allcourse($allcourses);
        // Download Tab Word
        // Course External Link
        $course_external_link = $tabs->categories();
        $course_external_link = json_decode(json_encode($course_external_link), true);
        $external_link = $tabs->external_link($course_external_link);
        // $external_link_custom =  $this->form_custom_link();
        // Course External Link.
        if (isset($_POST['external_link'])) {
            global $DB;
            $external_links = $_POST['external_link'];
            $cat_ids = $_POST['cat_id'];
            for ($i = 0; $i < count($external_links); $i++) {
                $external_links_data = $DB->get_record_sql("SELECT * FROM {course_external_links} WHERE category_id=? LIMIT 1", array(intval($cat_ids[$i])));
                $data = new stdClass();
                if (isset($external_links_data->category_id)) {
                    $data->id = $external_links_data->id;
                    $data->category_id = intval($cat_ids[$i]);
                    $data->external_link = $external_links[$i];
                    $data->updated_at = date('Y-m-d h:i:s');
                    $DB->update_record('course_external_links', $data);
                } else {
                    $data->category_id = intval($cat_ids[$i]);
                    $data->external_link = $external_links[$i];
                    $data->created_at = date('Y-m-d h:i:s');
                    $DB->insert_record('course_external_links', $data);
                }
            }
        }
        $get_category_course_count_user = $adminifos->get_category_course_registered_user();
        global $CFG, $DB;
        $categories = $tabs->categories();
        $column = array();
        $residency = new moodle_url('/course/editcategory.php?parent=0');
        $column[] = '<a target="_blank" href="' . $residency . '">Add New Residency</a>';
        $column[] = '';
        $total_submissions = array(); // Total Submission with Residency in each index
        $total_registered = array(); // Total Registered in each residency
        $categories_courses = array(); // Courses in each residency
        $course_details = array(); // Course Details
        $course_new = array();
        $total_pending = array(); // Number of Pending Courses From Grading of Assignments
        $upload_category_select_box = '<select class="form-control upload_category_box_main">'
                . '<option>Select Residency</option>'; // Upload Tab Select Resendency
        $upload_course_select_box_full_residency = array();
        $upload_course_select_box_category = array();
        foreach ($categories as $category) { // Iterate Each Residency
            $course_array = array(); // Course Array
            $course_details_arr = array(); // Refresh Course Details Array to fill in each residency
            $courses_assign = array(); // Assignment of each course
            $column[] = $category->idnumber; // Residency Code
            $assign_arr = array(); // Collect All Assignments Ids in array
            // Total Registered in each residency
            $count_total_registered = $DB->get_record_sql("SELECT count(*) as total_registered FROM {user_info_data} ui,{user} u WHERE u.id = ui.userid and data like '%" . $category->idnumber . "%'");
            $total_registered[$category->idnumber] = $count_total_registered->total_registered; // Fill in residency index
            // Check for child categories
            $child_categories = $DB->get_records_sql("SELECT * FROM {course_categories} WHERE parent='" . $category->id . "' and path Like '%" . $category->id . "%' and coursecount > 0 order by sortorder asc");
            $upload_category_select_box .= '<option value="' . $category->idnumber . '">' . $category->name . '</option>';
            $main_residency_box = '<select onChange="changeCourse(this);" class="form-control upload_category_box ' . $category->idnumber . '">'
                    . '<option>Select Courses</option>'; // Upload Tab Select All Residency Course;
            foreach ($child_categories as $child_category) {
                $sub_categories[] = '"' . $child_category->id . '"';
//                $upload_category_select_box .= '<option value="'.$child_category->idnumber.'">--'.$child_category->name.'</option>';
                $sub_residency_box = '<select onChange="changeCourse(this.value);" id="' . $child_category->idnumber . '" class="form-control upload_category_box">'
                        . '<option>Select Courses</option>'; // Upload Tab Select All Residency Course;
//            if (count($child_categories) > 1) {
//                $sub_categories_in = implode(',', $sub_categories);

                $courses = $DB->get_records_sql("SELECT * FROM {course} WHERE category =" . $child_category->id . " AND enddate > " . time() . " order by sortorder asc");
                foreach ($courses as $course) {
                    $course_array[] = $course->id;
                    $main_residency_box .= '<option  value="' . $course->id . '">' . $course->shortname . '</option>';
                    $sub_residency_box .= '<option value="' . $course->id . '">' . $course->shortname . '</option>';
                    $assigns = $DB->get_records_sql("SELECT * FROM {assign} WHERE course =" . $course->id . " AND duedate > " . time());
                    $course_details_arr[$course->id] = $course;
                    foreach ($assigns as $assign) {
                        $courses_assign[$course->id][$assign->id] = $assign;
                        $assign_arr[] = $assign->id;
                    }
//                    $course_details_arr[$course->id]['assign'] = $courses_assign;
                }
                $sub_residency_box .= '</select>';
//            }
            }
            $main_residency_box .= '</select>';

            $courses = $DB->get_records_sql("SELECT * FROM {course} WHERE category =" . $category->id . " AND enddate > " . time() . " order by sortorder asc");
            foreach ($courses as $course) {
                $course_array[] = $course->id;
                $assigns = $DB->get_records_sql("SELECT * FROM {assign} WHERE course =" . $course->id . " AND duedate > " . time());
                $course_details_arr[$course->id] = $course;
                foreach ($assigns as $assign) {
                    $courses_assign[$course->id][$assign->id] = json_decode(json_encode($assign));
                    $assign_arr[] = $assign->id;
                }
//                $course_details_arr[$course->id]['assign'] = $courses_assign;
            }

            $courses = implode(',', $course_array);
            $assign_ids = implode(',', $assign_arr);
            $upload_course_select_box_full_residency[$category->idnumber] = $main_residency_box;
//            $upload_course_select_box_category[$category->idnumber] = $main_residency_box;
            $sql = 'SELECT count(*) as remaining FROM {assign_submission} s, {assign_grades} g WHERE g.assignment=s.assignment and g.userid = s.userid and status="submitted" and g.assignment in (' . $assign_ids . ') and g.grade != -1 ';
            $pending_assignments = $DB->get_record_sql($sql); // "SELECT count(g.id) as remaining FROM {assign_grades} g WHERE g.assignment in (".$assign_ids.") and g.grader = '-1'");
            $total_submitted = $DB->get_record_sql("SELECT count(*) as total_submitted FROM {assign} os, {assign_submission} oss WHERE os.id = oss.assignment and oss.status='submitted' and os.course in (" . $courses . ") ");
            $total_submissions[$category->idnumber] = $total_submitted->total_submitted;
            $total_pending[$category->idnumber] = $total_submitted->total_submitted - $pending_assignments->remaining;
            $categories_courses[$category->idnumber] = $course_array;
            $course_details[$category->idnumber] = $course_details_arr;
            $course_details[$category->idnumber]['assign'] = $courses_assign;
        }
        $upload_category_select_box .= '</select>';
        /*
         * Overview Section Start
         */
        $remaining = $DB->get_record_sql('SELECT duedate FROM {assign} ORDER BY `duedate` DESC limit 1 ');
        $remaining = $remaining->duedate - time();
        $remaining = round($remaining / (60 * 60 * 24));
        $overview = '<div class="tab-content" id="mypublic-tab">
                                        <div class="tab-pane fade show active" id="nav-overviews" role="tabpanel" aria-labelledby="courses-tab">
                                        <div class="table-responsive">
                                        <div class=" overview-table">
                                            <table class="table table-striped table-eodo-dashboard">
                                                    <thead>
                                                      <tr>';
        $total_remaining = 0;
        foreach ($column as $col) {
            $overview .= '<th>' . $col . '</th>';
            $total_remaining = $total_remaining + $total_pending[$col];
        }
        $overview .= '</tr>
                                                    </thead>
                                                    <tbody>
                                                      <tr  class="top-row">
                                                        <th>Total registered</th>
                                                        <td></td>';
        foreach ($total_registered as $key => $val) {
            $overview .= '<td  class="top-row">' . $val . '</td>';
        }
        $overview .= '</tr>
                                                      <tr  class="top-row" style="border-bottom: 3px solid #dee2e6;">
                                                        <th>Total submissions</th>
                                                        <td></td>';
        foreach ($total_submissions as $key => $val) {
            $overview .= '<td>' . $val . '</td>';
        }
        $i = 0;
        $downloads = '<table class="table table-striped table-eodo-dashboard">';

        $uploads = '<table class="table table-striped table-eodo-dashboard table-eodo-uploads">';
        $uploads .= '<thead>'
                . '<tr class="course-' . $course->id . '">'
                . '<th style="width:10%">Residency</th>'
                . '<th style="width:20%">Name</th>'
                . '<th style="width:10%">Course</th>'
                . '<th style="width:30%">Files</th>'
                . '<th style="width:10%">Uploaded On</th>'
                . '<th style="width:10%">Days Since Submission</th>'
                . '<th style="width:10%">Corrected On</th>'
                . '</tr>'
                . '</thead>'
                . '<tbody>';
        foreach ($course_details as $key => $courses) {
            $downloads .= '<tr id="' . $key . '">'
                    . '<td colspan="3"> <h3>' . $key . '</h3></td>'
                    . '</tr>';

            foreach ($courses as $course) {
//                    echo '<pre>';
//                    print_r($course);exit; 

                $assignments = $courses['assign'][$course->id];
                if (count($assignments) > 0) {

                    $overview .= '<tr rowspan="' . count($assignments) . '">';
                    $overview .= '<th>' . $course->shortname . '</th>'
                            . '<td style="padding:0;"colspan="3"><table class="course_assignment" >';

//                    $uploads .= '<tr id="'.$course->id.'">';
//                    $uploads .= '<td colspan="7" style="padding:0;"><table class="course_assignment" >';
                    $assignment_id = array();
                    foreach ($assignments as $assignment) {
                        $total_submitted = $DB->get_record_sql("SELECT COUNT(*) as total_submitted FROM {assign_submission} WHERE assignment = " . $assignment->id . " and status = 'submitted' ORDER BY `status` DESC ");
                        $overview .= '<tr style="border: none;" ><td style="border: none;" >';

                        $overview .= $assignment->name;
                        $overview .= '</td>';


                        $overview .= '<td>' . $total_submitted->total_submitted . '</td><td></td>';


                        $overview .= '</tr>';

                        $assignment_id[] = $assignment->id;
                    }
                    // -------- Upload Section ----------------- //
                    $assignments_courses = implode(',', $assignment_id);
                    
//                    if($download_files_links != ''){

                    $course_assign_sections = $DB->get_records_sql('SELECT * FROM {course_modules} WHERE course = ' . $course->id . ' and instance in (' . $assignments_courses . ')  order by course asc ');
                    foreach ($course_assign_sections as $section) {
                            
                        $grading = new moodle_url('/mod/assign/view.php?id=' . $section->id . '&action=grading');
                        $grader = new moodle_url('/mod/assign/view.php?id=' . $section->id . '&action=grader');

                        $section_html = '<center>'
                                . '<div class="submissionlinks">'
                                . '<a class="btn btn-secondary" href="' . $grading . '">View all enrolled users</a>'
                                . '<a class="btn btn-primary ml-1" href="' . $grader . '">Grade all</a>'
                                . '</div>'
                                . '</center>';
                        $show_section_breaker = false;
//                        if ($download_files_links != '') {
                            $sql = 'SELECT * FROM {assign_submission} WHERE assignment =' . $section->instance . ' and userid != 2 ORDER BY `id` DESC ';
                            $assignment_submissions = $DB->get_records_sql($sql);
                            $sumbission_count = 0;
                            foreach ($assignment_submissions as $assignment_submission) {
                                $assign_grade = $DB->get_record_sql('SELECT * FROM {assign_grades} WHERE assignment='.$section->instance.' and userid='.$assignment_submission->userid.' ORDER BY `assignment` ASC ');
                                $time_corrected = '';
                                $style = '';
                                if($assign_grade->grader != '-1'){
                                    $time_corrected = date('d.m.Y',$assign_grade->timemodified);
                                }else{
                                   $style = 'color:red'; 
                                }
                                $download_files = $DB->get_records_sql('SELECT * FROM {context} oc, {files} of WHERE oc.id = of.contextid and oc.instanceid=' . $section->id . ' and of.filesize != 0 and of.component LIKE "%assignsubmission_file%" and userid= ' . $assignment_submission->userid);
                                $download_files_links = '';
                                $uploaded_on = '';
                                $remaining_days_html = '';
                                $sql = 'SELECT count(*) as check_enrol_count FROM {enrol} e, {user_enrolments} ue WHERE e.id=ue.enrolid AND userid='.$assignment_submission->userid.' and e.roleid=5 and e.courseid='.$course->id;
                                $user_enrolled = $DB->get_record_sql($sql);
                                if($user_enrolled->check_enrol_count > 0){
                                    foreach ($download_files as $download_file) {
                                        $file_link = new moodle_url('/pluginfile.php/' . $download_file->contextid . '/' . $download_file->component . '/' . $download_file->filearea . '/' . $download_file->itemid . '/' . $download_file->filename . '?forcedownload=1');
                                        $assign_link = new moodle_url('/mod/assign/view.php?id='.$section->id.'&rownum=0&action=grader&userid='.$assignment_submission->userid);
                                        $download_files_links .= '<li><a  style="'.$style.'" href="' . $assign_link . '"> ' . $download_file->filename . '</a></li>';
                                        $uploaded_on .= '<li style="'.$style.'">' . date('d.m.Y', $download_file->timemodified) . "</li>";
                                        $remaining_days = time() - $download_file->timemodified;
                                        $remaining_days = round($remaining_days / (60 * 60 * 24));
                                        $remaining_days_html .= '<li style="'.$style.'">' . $remaining_days . '</li>';
                                    }
                                    
                                    if($download_files_links){
//                                        if($sumbission_count == 0){
//                                            $download_files_exams = $DB->get_records_sql('SELECT * FROM {context} oc, {files} of WHERE oc.id = of.contextid and oc.instanceid=' . $section->id . ' and of.filesize != 0 and of.component = "mod_assign" ');
//                                            $download_file_exam_links = '';
//                                            foreach ($download_files_exams as $download_file) {
//                                                $file_link = new moodle_url('/pluginfile.php/' . $download_file->contextid . '/' . $download_file->component . '/' . $download_file->filearea . '/0/' . $download_file->filename . '?forcedownload=1');
//                                                $download_file_exam_links .= '<li><a href="' . $file_link . '"> ' . $download_file->filename . '</a></li>';
//                                            }
//                                            $uploads .= "<tr><td colspan='7'><ul><li><b>Course Assignment/Exam File<b></li> " . $download_file_exam_links . "</ul></td></tr>";
//                                    }
                                        $show_section_breaker = true;
                                        $sql = 'SELECT * FROM {user} WHERE id = ' . $assignment_submission->userid . ' ORDER BY `id` DESC ';
                                        $user = $DB->get_record_sql($sql);
                                        $uploads .= '<tr class="res-' . $key . ' course-' . $course->id . ' courses-sections">';
                                        $uploads .= '<td style="width:10%";padding:20px;>' . $key . '</td>';
                                        $uploads .= '<td style="width:20%;padding:20px;">' . $user->firstname . " " . $user->lastname . '</td>';
                                        $uploads .= '<td style="width:10%;padding:20px;'.$style.'">' . $course->shortname . '</td>';
                                        $uploads .= '<td style="width:30%;padding:20px;"><ul>' . $download_files_links . '</ul></td>';
                                        $uploads .= '<td style="width:10%;padding:20px;"><ul>' . $uploaded_on . '</ul></td>';
                                        $uploads .= '<td style="width:10%;padding:20px;"><ul>' . $remaining_days_html . '</ul></td>';
                                        $uploads .= '<td style="width:10%;padding:20px;">' . $time_corrected . '</td>';
                                        $uploads .= '</tr>';
                                    }
                                }
                                $sumbission_count = $sumbission_count+1 ;
                            }
                            if($show_section_breaker){
                                $uploads .= '<tr class="res-' . $key . ' course-' . $course->id . ' courses-sections"><td colspan="7">' . $section_html . "</td></tr>";
                            }
//                        }
                    }
//                    }
                    /// --------------------------  Download Section ------------------------- ///
                    $downloads .= '<tr rowspan="' . count($assignments) . '">';
                    $downloads .= '<th>' . $course->shortname . '</th>'
                            . '<td>';
                    $assignments = implode(',', $assignment_id);
                    $course_assign_sections = $DB->get_records_sql('SELECT * FROM {course_modules} WHERE course = ' . $course->id . ' and instance in (' . $assignments . ') ');
                    foreach ($course_assign_sections as $section) {
                        $download_files = $DB->get_records_sql('SELECT * FROM {context} oc, {files} of WHERE oc.id = of.contextid and oc.instanceid=' . $section->id . ' and of.filesize != 0 and of.component = "mod_assign" ');
                        foreach ($download_files as $download_file) {
                            $file_link = new moodle_url('/pluginfile.php/' . $download_file->contextid . '/' . $download_file->component . '/' . $download_file->filearea . '/0/' . $download_file->filename . '?forcedownload=1');
                            $downloads .= '<a href="' . $file_link . '"> ' . $download_file->filename . '</a><br/>';
                        }
                    }
                    $course_link = new moodle_url('/course/view.php?id=' . $course->id);
                    $downloads .= '</td>';
                    $downloads .= '<td><a class="btn btn-primary float-right mt-2" href="' . $course_link . '">Manage Course Sections</a></td>';
                    $downloads .= '</td></tr>';

//                    $uploads .= '</td></tr></table>';
                    /// --------------------------  Download Section ------------------------- ///

                    $overview .= '</table></td></tr>';
                }
            }
            $i++;
        }

        $overview .= ' </tbody>
                                                </table></div>
                                                <div class="overview-info">
                                                    <h4>Corrections Pending: ' . $total_remaining . '</h4>
                                                    ِ<h4>No. of days remaining: ' . $remaining . '</h4>
                                                </div>
                                                </div>
                                        </div> ';

        /*
         * Overview Section End
         */


        /// --------------------------  Download Section ------------------------- ///

        $downloads .= '</table>';
        $uploads .= '</tbody></table>';


        //// -------------------------  Uploads Pending Section ----------------- ///
        if (count($total_pending) > 0) {
            $pending_html = ' <div class="table-responsive">
                                                            <table class="table table-striped">
                                                              <thead>
                                                                <tr>
                                                                  <th>Residency</th>
                                                                  <th>Pending</th>
                                                                </tr>
                                                              </thead>
                                                              <tbody>';
            foreach ($total_pending as $key => $pending_total) {
                $pending_html .= '<tr>';
                $pending_html .= '<td>' . $key . '</td><td>' . $pending_total . '</td>';
                $pending_html .= '</tr>';
            }
            $pending_html .= '</tbody>
                                                            </table>
                                                        </div>';
        }
        $course_select_box = '';
        foreach ($upload_course_select_box_full_residency as $upload_course) {
            $course_select_box .= '<div class="form-group">' . $upload_course . '</div>';
        }
//        foreach ($upload_course_select_box_category as $upload_course1){
//            $course_select_box .= '<div class="form-group">'.$upload_course1.'</div>';
//        }
        $this->content = new stdClass;
        $this->content->text = '<section id="region-mains" class="cust-box-tab-admin" style="width:100%">    
            <div class="row m-0">
                <div class="col-md-12">
                    <ul class="d-flex nav nav-tabs {{#is_siteadmin}}remove_border{{/is_siteadmin}} Dash_tabs" id="myTab" role="tablist">
                               
                        <li class="nav-item p-0 mr-0">
                            <a class="nav-item nav-link py-2 active" id="nav-overviews-tab" data-toggle="tab" href="#nav-overviews" role="tab" aria-controls="nav-overviews" aria-selected="true">Overview</a>
                        </li>
                               
                       <li class="nav-item p-0 mr-0">
                            <a class="nav-item nav-link py-2" id="nav-downloads-tab" data-toggle="tab" href="#nav-downloads" role="tab" aria-controls="nav-downloads" aria-selected="false">Downloads</a>
                        </li>

                        <li class="nav-item p-0 mr-0">
                            <a class="nav-item nav-link py-2" id="nav-uploads-tab" data-toggle="tab" href="#nav-uploads" role="tab" aria-controls="nav-uploads" aria-selected="false">Uploads</a>
                        </li>

                        <li class="nav-item p-0 mr-0">
                            <a class="nav-item nav-link py-2" id="nav-accounts-tab" data-toggle="tab" href="#nav-accounts" role="tab" aria-controls="nav-accounts" aria-selected="false">Accounts</a>
                        </li>

                        <li class="nav-item p-0 mr-0">
                            <a class="nav-item nav-link py-2" id="nav-codes-tab" data-toggle="tab" href="#nav-codes" role="tab" aria-controls="nav-codes" aria-selected="false">Codes</a>
                        </li>

                        <li class="nav-item p-0 mr-0">
                            <a class="nav-item nav-link py-2" id="nav-invoices-tab" data-toggle="tab" href="#nav-invoices" role="tab" aria-controls="nav-invoices" aria-selected="false">Invoices</a>
                        </li>
                        <li class="nav-item p-0 mr-0">
                            <a class="nav-item nav-link py-2" id="nav-external-links-tab" data-toggle="tab" href="#nav-external-links" role="tab" aria-controls="nav-external-links" aria-selected="false">Course External Links</a>
                        </li>
                    </ul>
                </div>
            </div>
        </section>';

        // -------------- Account Section ------------- //
        $accounts_registered = '';
        $account_user_sections = '<thead>
                                                              <tr>
                                                                <th>User Id</th>
                                                                <th>First Name</th>
                                                                <th>Last Name</th>
                                                                <th>User Email</th>
                                                                <th>Reg. Code</th>
                                                              </tr>
                                                            </thead><tbody>';
        foreach ($total_registered as $key => $val) {
            $accounts_registered .= '<tr>'
                    . '<td>'.$key.'</td>'
                    . '<td>'.$val.'</td>'
                    . '</tr>';
            $users = $DB->get_records_sql("SELECT * FROM {user_info_data} ui,{user} u WHERE u.id = ui.userid and data like '%" . $key . "%'");
            foreach ($users as $user){
                if(isset($user->email)){
                $account_user_sections .= '<tr id="'.$key.'">'
                        . '<td>'.$user->id.'</td>'
                        . '<td>'.$user->firstname.'</td>'
                        . '<td>'.$user->lastname.'</td>'
                        . '<td>'.$user->email.'</td>'
                        . '<td>'.$key.'</td>'
                        . '</tr>';
                }
            }
        }
        $account_user_sections .='</tbody>';
        $this->content->footer = '<section id="region-main" class="cust-box-tab" style="overflow-x: hidden;">
                    <div class="card mymaincontent">
                        <div class="row">
                            <div class="col-md-12" style="overflow:hidden;">
                                <div>
                                    
                                          ' . $overview . ' 
                                            <div class="tab-pane fade" id="nav-downloads" role="tabpanel" aria-labelledby="nav-downloads-tab">
                                                <div class="container">  
                                                <div class="table-responsive">         
                                                  ' . $downloads . '
                                                </div>
                                                </div>

                                            </div>


                                            <div class="tab-pane fade" id="nav-uploads" role="tabpanel" aria-labelledby="nav-uploads-tab">
                                                <div class="container">
                                                  <div class="row">
                                                    
                                                    <div class="col-sm-6">
                                                   '
                . $pending_html .
                '
                                                    </div>

                                                    <div class="col-sm-6" style="margin-top:50px">
                                                        <form>
                                                          <div class="form-group">
                                                            ' . $upload_category_select_box . '
                                                                
                                                           
                                                          </div>
                                                          <div class="form-group">
                                                              ' . $course_select_box . '
                                                          </div>
                                                        </form>
                                                    </div>

                                                  </div>
                                                  <br><br>
                                                  <div class="row">
                                                    <div class="col-sm-12">
                                                    <div class="table-responsive">
                                                        ' . $uploads . '
                                                    </div>
                                                    </div>
                                                  </div>

                                                </div>
                                            </div>


                                            <div class="tab-pane fade" id="nav-accounts" role="tabpanel" aria-labelledby="nav-accounts-tab">

                                                <div class="container">
                                                  <div class="row">
                                                    
                                                    <div class="col-sm-6">
                                                    <div class="table-responsive">
                                                        <table class="table table-striped">
                                                            <thead>
                                                              <tr>
                                                                <th>Residency</th>
                                                                <th>Registered</th>
                                                              </tr>
                                                            </thead>
                                                            <tbody>
                                                              ' . $accounts_registered . '
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                    </div>

                                                    <div class="col-sm-6" style="margin-top:50px">
                                                       <form>
                                                          <div class="form-group">
                                                            ' . $upload_category_select_box . '
                                                                
                                                           
                                                          </div>
                                                        </form>
                                                    </div>

                                                  </div>
                                                  <div class="row">
                                                                                                      <div class="col-sm-12">
                                                    <div class="table-responsive">
                                                        <table class="table table-striped">
                                                            '.$account_user_sections.'
                                                        </table>
                                                    </div>
                                                    </div>
                                                </div>
                                                </div>
                                            </div>


                                            <div class="tab-pane fade" id="nav-codes" role="tabpanel" aria-labelledby="nav-codes-tab" style="padding:20px;">
                                                
                                              <div class="container">
                                                  <div class="row">
                                                    <div class="col-sm-6">
                                                    <div class="table-responsive">
                                                        <table class="table table-striped">
                                                            <thead>
                                                              <tr>
                                                                <th>Edit/Add Residency</th>
                                                                <th>Reg. Code</th>
                                                              </tr>
                                                            </thead>
                                                            <tbody>
                                                              ' . $code_category . '
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                    <div class="row">


                                                    <div class="col-sm-6">
                                                    <div class="table-responsive">
                                                        <table class="table table-striped table-responsive">
                                                            '.$account_user_sections.'
                                                        </table>
                                                    </div>
                                                    </div>

                                                  </div>
                                                </div>
                                                <button style="display:none;" type="button" class="btn btn-primary float-right mt-2">Save</button>  

                                            </div>


                                            <div class="tab-pane fade" id="nav-invoices" role="tabpanel" aria-labelledby="nav-invoices-tab">
                                                

                                              <div class="container">
                                                  <div class="row">
                                                    
                                                    <div class="col-sm-12">
                                                    <div class="table-responsive">
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
                                                              ' . $invoices_cat . '
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                    </div>


                                                  </div>
                                                  

                                                </div>
                                                
                                            </div>



                                            <div class="tab-pane fade" id="nav-external-links" role="tabpanel" aria-labelledby="nav-external-links-tab">

                                              <div class="container">
                                                <div class="row">
                                                  <div class="col-sm-12">
                                                         <form method="post" class="form-inline" action="" style="padding-bottom: 20px !important;">
                                                         <div class="table-responsive">
                                                      <table class="table table-striped">
                                                          <thead>
                                                            <tr>
                                                              <th>Category ID</th>
                                                              <th>Category Name</th>
                                                              <th>Course External Links</th>
                                                            </tr>
                                                          </thead>
                                                          <tbody>
                                                            ' . $external_link . '
                                                            
                                                          </tbody>
                                                      </table>
                                                      </div>
                                                      <button type="submit" class="btn btn-primary float-right mt-2" id="external_linkss">Save</button>
                                                    </form>
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
