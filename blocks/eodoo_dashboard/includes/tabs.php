<?php

class tabs {

    //Download Taps Functions
    public function allcourse($allcourses) {
        $array = [];
        foreach ($allcourses as $key => $value) {
            $row = '<tr><td> ' . $allcourses[$key]['fullname'] . ' </td></tr>';
            array_push($array, $row);
        }
        $string_version = implode(',', $array);
        return $string_version;
    }

//Download Taps Functions
    // Upload tabs Functions

    public function upload_courses($upload_course) {
        $array = [];
        foreach ($upload_course as $key => $value) {
            $row = '<tr>
                      <td>' . $upload_course[$key]['name'] . '</td>
                      <td>12</td>
                  </tr>';
            array_push($array, $row);
        }
        $string_version = implode(',', $array);
        return $string_version;
    }

    // select_cat
    public function select_cat($upload_course) {
        $array = [];
        foreach ($upload_course as $key => $value) {
            $row = '<option>' . $upload_course[$key]['name'] . '</option>';
            array_push($array, $row);
        }
        $string_version = implode(',', $array);
        return $string_version;
    }

    // select_cat
    // select_course
    public function select_course($upload_course) {
        $array = [];
        foreach ($upload_course as $key => $value) {
            $row = '<option>' . $upload_course[$key]['fullname'] . '</option>';
            array_push($array, $row);
        }
        $string_version = implode(',', $array);
        return $string_version;
    }

    // select_course
    // all_course_data
    public function all_course_data($upload_course) {
        $array = [];
        foreach ($upload_course as $key => $value) {
            $row = '<tr>
                    <td>' . $upload_course[$key]['name'] . '</td>
                    <td>' . $upload_course[$key]['firstname'] . '</td>
                    <td>' . $upload_course[$key]['fullname'] . '</td>
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

    public function upload_accountscourses($upload_course) {
        $array = [];
        foreach ($upload_course as $key => $value) {
            $row = '<tr>
                      <td>' . $upload_course[$key]['name'] . '</td>
                      <td>' . count($upload_course[$key]['id']) . '</td>
                  </tr>';
            array_push($array, $row);
        }
        $string_version = implode(',', $array);
        return $string_version;
    }

    // select_accountscat
    public function select_accountscat($upload_course) {
        $array = [];
        foreach ($upload_course as $key => $value) {
            $row = '<option>' . $upload_course[$key]['name'] . '</option>';
            array_push($array, $row);
        }
        $string_version = implode(',', $array);
        return $string_version;
    }

    // select_accountscat
    // select_accountscourse
    public function select_accountscourse($upload_course) {
        $array = [];
        foreach ($upload_course as $key => $value) {
            $row = '<option>' . $upload_course[$key]['fullname'] . '</option>';
            array_push($array, $row);
        }
        $string_version = implode(',', $array);
        return $string_version;
    }

    // select_accountscourse
    // Accounts tabs Functions
    // Codes tabs Functions
    public function code_category($codes) {
        $array = [];
        foreach ($codes as $key => $value) {
            $row = '<tr>
                    <td>' . $codes[$key]['name'] . '</td>
                    <td>MR2019</td>
                  </tr>';
            array_push($array, $row);
        }
        $string_version = implode(',', $array);
        return $string_version;
    }

    public function code_courses($codes) {
        $array = [];
        foreach ($codes as $key => $value) {
            $row = '<tr>
                    <td>' . $codes[$key]['fullname'] . '</td>
                    <td>' . $codes[$key]['shortname'] . '</td>
                  </tr>';
            array_push($array, $row);
        }
        $string_version = implode(',', $array);
        return $string_version;
    }

    // Codes tabs Functions
    // invoices tabs Functions

    public function invoices_cat($invoices) {
        $array = [];
        foreach ($invoices as $key => $value) {
            $row = '<tr>
                    <td>' . $invoices[$key]['firstname'] . '</td>
                    <td>' . $invoices[$key]['lastname'] . '</td>
                    <td>' . $invoices[$key]['user_email'] . '</td>
                    <td>' . $invoices[$key]['discount_code'] . '</td>
                  </tr>';
            array_push($array, $row);
        }
        $string_version = implode(',', $array);
        return $string_version;
    }

    public function external_link($course_external_link) {
        global $DB;
        $array = [];
        foreach ($course_external_link as $key => $value) {
            $user_info_field = $DB->get_record_sql("SELECT * FROM {course_external_links} WHERE category_id=" . $course_external_link[$key]['id'] . " LIMIT 1");

            $row = '<tr>
                    <td>' . $course_external_link[$key]['id'] . '</td>
                    <td>' . $course_external_link[$key]['name'] . '</td>
                    
                    <td>
                           <div class="form-group">
                             <input type="text" value="' . $user_info_field->external_link . '" class="form-control" id="link_custom" placeholder="Course External Link" name="external_link[]">
                             <input type="hidden" class="form-control" value="' . $course_external_link[$key]['id'] . '" name="cat_id[]">
                           </div>
                    </td>
                  </tr>';
            array_push($array, $row);
        }

        $string_version = implode(',', $array);
        return $string_version;
    }

    public function categories() {
        global $DB;

        $sql = "SELECT DISTINCT * FROM oodo_course_categories where parent=0 and idnumber <> 'singlecourse' and visible=1 order by sortorder asc";
        $categories = $DB->get_records_sql($sql);

        return $categories;
    }

    public function get_overview_content() {
       
        

        return $overview;
    }

}
