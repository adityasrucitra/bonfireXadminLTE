<?php defined('BASEPATH') || exit('No direct script access allowed');

/**
 * Management controller
 */
class Management extends Admin_Controller
{
    protected $permissionCreate = 'Plant.Management.Create';
    protected $permissionDelete = 'Plant.Management.Delete';
    protected $permissionEdit   = 'Plant.Management.Edit';
    protected $permissionView   = 'Plant.Management.View';

    /**
     * Constructor
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();

        // $this->auth->restrict($this->permissionView);
        // $this->load->model('plant/plant_model');
        // // $this->load->model('area/area_model');
        // $this->lang->load('plant');

        // $this->form_validation->set_error_delimiters("<span class='error'>", "</span>");

        // Template::set_block('sub_nav', 'management/_sub_nav');

        // Assets::add_module_js('plant', 'plant.js');
    }


    public function index(){
        echo 123;
    }

    /**
     * Display a list of plant data.
     *
     * @return void
     */
    public function index_($offset = 0)
    {

        // Deleting anything?
        if (isset($_POST['delete'])) {
            $this->auth->restrict($this->permissionDelete);
            $checked = $this->input->post('checked');
            if (is_array($checked) && count($checked)) {

                // If any of the deletions fail, set the result to false, so
                // failure message is set if any of the attempts fail, not just
                // the last attempt

                $result = true;
                foreach ($checked as $pid) {
                    $deleted = $this->plant_model->delete($pid);
                    if ($deleted == false) {
                        $result = false;
                    }
                }
                if ($result) {
                    Template::set_message(count($checked) . ' ' . lang('plant_delete_success'), 'success');
                } else {
                    Template::set_message(lang('plant_delete_failure') . $this->plant_model->error, 'error');
                }
            }
        }
        $pagerUriSegment = 5;
        $pagerBaseUrl = site_url(SITE_AREA . '/management/plant/index') . '/';

        $limit  = $this->settings_lib->item('site.list_limit') ?: 15;

        $this->load->library('pagination');
        $pager['base_url']    = $pagerBaseUrl;
        // $pager['total_rows']  = $this->plant_model->count_all();
        $pager['per_page']    = $limit;
        $pager['uri_segment'] = $pagerUriSegment;

        if (isset($_POST['search_terms'])) {
            $pager['total_rows']  = $this->plant_model
                ->join('bf_area', 'bf_area.id = bf_plant.area_id')
                ->join('bf_glass_meters', 'bf_glass_meters.id = bf_plant.glass_meter', 'left')
                ->like('bf_area.area', $_POST['search_terms'])
                ->or_like('plant_code', $_POST['search_terms'])
                ->or_like('plant_name', $_POST['search_terms'])
                ->count_all();

            $records = $this->plant_model
                ->select('bf_plant.*, bf_area.area, bf_glass_meters.size')
                ->join('bf_area', 'bf_area.id = bf_plant.area_id')
                ->join('bf_glass_meters', 'bf_glass_meters.id = bf_plant.glass_meter', 'left')
                ->like('bf_area.area', $_POST['search_terms'])
                ->or_like('plant_code', $_POST['search_terms'])
                ->or_like('plant_name', $_POST['search_terms'])
                ->limit($limit, $offset)
                ->find_all();
        } else {
            $pager['total_rows']  = $this->plant_model
                ->join('bf_area', 'bf_area.id = bf_plant.area_id')
                ->join('bf_glass_meters', 'bf_glass_meters.id = bf_plant.glass_meter', 'left')
                ->count_all();

            $records = $this->plant_model
                ->select('bf_plant.*, bf_area.area, bf_glass_meters.size')
                ->join('bf_glass_meters', 'bf_glass_meters.id = bf_plant.glass_meter', 'left')
                ->join('bf_area', 'bf_area.id = bf_plant.area_id')
                ->limit($limit, $offset)
                ->find_all();
        }

        $this->pagination->initialize($pager);
        // $this->plant_model->limit($limit, $offset);

        Template::set('records', $records);

        Template::set('toolbar_title', lang('plant_manage'));

        Template::render();
    }

    /**
     * Create a plant object.
     *
     * @return void
     */
    public function create()
    {
        $this->auth->restrict($this->permissionCreate);

        if (isset($_POST['save'])) {
            if ($insert_id = $this->save_plant()) {
                log_activity($this->auth->user_id(), lang('plant_act_create_record') . ': ' . $insert_id . ' : ' . $this->input->ip_address(), 'plant');
                Template::set_message(lang('plant_create_success'), 'success');

                redirect(SITE_AREA . '/management/plant');
            }

            // Not validation error
            if (!empty($this->plant_model->error)) {
                Template::set_message(lang('plant_create_failure') . $this->plant_model->error, 'error');
            }
        }
        Template::set('toolbar_title', lang('plant_action_create'));

        $this->load->model('area/area_model');
        $areas = $this->area_model->as_array()->find_all();
        foreach ($areas as $area) {
            $options[$area['id']] = $area['area'];
        }
        Template::set('options', $options);

        $this->load->model('plant/glassmeter_model');
        $glassmeters = $this->glassmeter_model->as_array()->find_all();
        foreach ($glassmeters as $glassmeter) {
            $glass[$glassmeter['id']] = $glassmeter['size'];
        }
        Template::set('glass', $glass);


        Template::render();
    }
    /**
     * Allows editing of plant data.
     *
     * @return void
     */
    public function edit()
    {
        $id = $this->uri->segment(5);
        if (empty($id)) {
            Template::set_message(lang('plant_invalid_id'), 'error');

            redirect(SITE_AREA . '/management/plant');
        }

        if (isset($_POST['save'])) {
            $this->auth->restrict($this->permissionEdit);

            if ($this->save_plant('update', $id)) {
                log_activity($this->auth->user_id(), lang('plant_act_edit_record') . ': ' . $id . ' : ' . $this->input->ip_address(), 'plant');
                Template::set_message(lang('plant_edit_success'), 'success');
                redirect(SITE_AREA . '/management/plant');
            }

            // Not validation error
            if (!empty($this->plant_model->error)) {
                Template::set_message(lang('plant_edit_failure') . $this->plant_model->error, 'error');
            }
        } elseif (isset($_POST['delete'])) {
            $this->auth->restrict($this->permissionDelete);

            if ($this->plant_model->delete($id)) {
                log_activity($this->auth->user_id(), lang('plant_act_delete_record') . ': ' . $id . ' : ' . $this->input->ip_address(), 'plant');
                Template::set_message(lang('plant_delete_success'), 'success');

                redirect(SITE_AREA . '/management/plant');
            }

            Template::set_message(lang('plant_delete_failure') . $this->plant_model->error, 'error');
        }

        Template::set('plant', $this->plant_model->find($id));

        $this->load->model('area/area_model');
        $areas = $this->area_model->as_array()->find_all();
        foreach ($areas as $area) {
            $options[$area['id']] = $area['area'];
        }
        Template::set('options', $options);

        $this->load->model('plant/glassmeter_model');
        $glassmeters = $this->glassmeter_model->as_array()->find_all();
        foreach ($glassmeters as $glassmeter) {
            $glass[$glassmeter['id']] = $glassmeter['size'];
        }
        Template::set('glass', $glass);


        Template::set('toolbar_title', lang('plant_edit_heading'));
        Template::render();
    }

    //--------------------------------------------------------------------------
    // !PRIVATE METHODS
    //--------------------------------------------------------------------------

    /**
     * Save the data.
     *
     * @param string $type Either 'insert' or 'update'.
     * @param int    $id   The ID of the record to update, ignored on inserts.
     *
     * @return boolean|integer An ID for successful inserts, true for successful
     * updates, else false.
     */
    private function save_plant($type = 'insert', $id = 0)
    {
        if ($type == 'update') {
            $_POST['id'] = $id;
        }

        // Validate the data
        $this->form_validation->set_rules($this->plant_model->get_validation_rules());
        if ($this->form_validation->run() === false) {
            return false;
        }

        // Make sure we only pass in the fields we want

        $data = $this->plant_model->prep_data($this->input->post());

        // Additional handling for default values should be added below,
        // or in the model's prep_data() method


        $return = false;
        if ($type == 'insert') {
            $id = $this->plant_model->insert($data);

            if (is_numeric($id)) {
                $return = $id;
            }
        } elseif ($type == 'update') {
            $return = $this->plant_model->update($id, $data);
        }

        return $return;
    }
}
