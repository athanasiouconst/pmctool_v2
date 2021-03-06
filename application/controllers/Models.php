<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Models extends CI_Controller {

    public function ViewModels($sort_by = 'mod_id', $sort_order = 'desc', $offset = 0) {
        if ($this->session->userdata('userIsLoggedIn')) {
            $this->load->model('Usermodel');

            //authentication of user
            $data['is_authenticated'] = $this->session->userdata('userIsLoggedIn');
            //user information
            $username = $this->session->userdata('username');
            $data['username'] = $this->session->userdata('username');
            $data['role'] = $this->Usermodel->getRole($username);

            //view the home page
            $this->load->model('ModelsModel');
            //pass messages
            $data['gens'] = $this->ModelsModel->getViewModels();
            $limit = 10;
            $results = $this->ModelsModel->searchViewModels($sort_by, $sort_order, $limit, $offset);
            $data['gen'] = $results['rows'];
            $data['num_result'] = $results['num_rows'];
            //pagination
            $this->load->library('pagination');
            $config = array();
            $config['base_url'] = site_url("Models/ViewModels/$sort_by/$sort_order");
            $config['total_rows'] = $data['num_result'];
            $config['per_page'] = $limit;
            $config['first_link'] = '&laquo; First ';
            $config['next_link'] = '&gt; Next ';
            $config['prev_link'] = 'Previous &lt; ';
            $config['last_link'] = 'Last &raquo;';
            $config['total_rows'] = $this->db->count_all('model');
            $config['uri_segment'] = 5;
            $this->pagination->initialize($config);
            $data['pagination'] = $this->pagination->create_links();
            $data['fields'] = array(
                'mod_name' => 'Title',
                'mod_description' => 'Description'
            );
            $data['sort_by'] = $sort_by;
            $data['sort_order'] = $sort_order;
            $this->load->view('pmctool/models', $data);
        } else {
            //if not authentication the go to Login Page
            $data['is_authenticated'] = FALSE;
            $this->load->model('ModelsModel');
            //pass messages
            $data['gens'] = $this->ModelsModel->getViewModels();
            $limit = 10;
            $results = $this->ModelsModel->searchViewModels($sort_by, $sort_order, $limit, $offset);
            $data['gen'] = $results['rows'];
            $data['num_result'] = $results['num_rows'];
            //pagination
            $this->load->library('pagination');
            $config = array();
            $config['base_url'] = site_url("Models/ViewModels/$sort_by/$sort_order");
            $config['total_rows'] = $data['num_result'];
            $config['per_page'] = $limit;
            $config['first_link'] = '&laquo; First ';
            $config['next_link'] = '&gt; Next ';
            $config['prev_link'] = 'Previous &lt; ';
            $config['last_link'] = 'Last &raquo;';
            $config['total_rows'] = $this->db->count_all('model');
            $config['uri_segment'] = 5;
            $this->pagination->initialize($config);
            $data['pagination'] = $this->pagination->create_links();
            $data['fields'] = array(
                'mod_name' => 'Title',
                'mod_description' => 'Description'
            );
            $data['sort_by'] = $sort_by;
            $data['sort_order'] = $sort_order;
            $this->load->view('pmctool/models', $data);
        }
    }

    public function ViewModelsCreationForm() {
        if ($this->session->userdata('userIsLoggedIn')) {
            $this->load->model('Usermodel');

            //authentication of user
            $data['is_authenticated'] = $this->session->userdata('userIsLoggedIn');
            //user information
            $username = $this->session->userdata('username');
            $data['username'] = $this->session->userdata('username');
            $data['role'] = $this->Usermodel->getRole($username);

            //view the home page
            $this->load->view('pmctoolContent/pmctoolModelsContent/pmctoolModelsContentInsert', $data);
        } else {
            //if not authentication the go to Login Page
            $data['is_authenticated'] = FALSE;
            $this->load->view('User/login/home', $data);
        }
    }

    public function CreateModels() {

        if ($this->session->userdata('userIsLoggedIn')) {
            $this->load->model('Usermodel');

            //authentication of user
            $data['is_authenticated'] = $this->session->userdata('userIsLoggedIn');
            //user information
            $username = $this->session->userdata('username');
            $data['username'] = $this->session->userdata('username');
            $data['role'] = $this->Usermodel->getRole($username);

            //view the home page
            $this->load->model('ModelsModel');
            $this->load->library('form_validation');
            $error = '';


            $this->form_validation->set_rules('mod_name', 'Title', 'trim|required|xss_clean');
            $this->form_validation->set_rules('mod_description', 'Description', 'trim|required|xss_clean');

            if ($this->form_validation->run() == FALSE) {
                $data['error'] = $error;
                $this->load->view('pmctoolContent/pmctoolModelsContent/pmctoolModelsContentInsert', $data);
            } else {
                if ($this->form_validation->run() == TRUE) {

                    $mod_name = stripslashes($_POST['mod_name']);
                    $mod_description = stripslashes($_POST['mod_description']);
                    $data = array(
                        'mod_id' => NULL,
                        'mod_name' => $mod_name, 'mod_description' => $mod_description
                    );
                    $this->ModelsModel->add_Models($data);

                    $this->session->set_flashdata('success_msg', '<div class="alert alert-success" style="font-size:24px; font:bold;">'
                            . 'Your Model has successfully been <strong>Registered</strong>!!'
                            . '</div>');
                    redirect('Models/ViewModels');
                }
            }
        } else {
            //if not authentication the go to Login Page
            $data['is_authenticated'] = FALSE;
            $this->load->view('User/login/home', $data);
        }
    }

    public function ViewModelsDelete($mod_id) {

        if ($this->session->userdata('userIsLoggedIn')) {
            $this->load->model('Usermodel');

            //authentication of user
            $data['is_authenticated'] = $this->session->userdata('userIsLoggedIn');
            //user information
            $username = $this->session->userdata('username');
            $data['username'] = $this->session->userdata('username');
            $data['role'] = $this->Usermodel->getRole($username);

            //view the home page
            $this->load->model('ModelsModel');
            $this->ModelsModel->ModelsDelete($mod_id);
            $this->session->set_flashdata('delete_msg', '<div class="alert alert-danger" style="font-size:24px; font:bold;">'
                    . 'Your Model has successfully been <strong>Deleted</strong>!!'
                    . '</div>');

            redirect('Models/ViewModels');
        } else {
            //if not authentication the go to Login Page
            $data['is_authenticated'] = FALSE;
            $this->load->view('User/login/home', $data);
        }
    }

    public function ViewModelsEditForm($mod_id, $sort_by = 'mod_id', $sort_order = 'asc', $offset = 0) {

        if ($this->session->userdata('userIsLoggedIn')) {
            $this->load->model('Usermodel');

            //authentication of user
            $data['is_authenticated'] = $this->session->userdata('userIsLoggedIn');
            //user information
            $username = $this->session->userdata('username');
            $data['username'] = $this->session->userdata('username');
            $data['role'] = $this->Usermodel->getRole($username);

            //view the home page
            $this->load->model('ModelsModel');
            $data['edit'] = $this->ModelsModel->getEditModels($mod_id);
            $this->load->view('pmctoolContent/pmctoolModelsContent/pmctoolModelsContentEdit', $data);
        } else {
            //if not authentication the go to Login Page
            $data['is_authenticated'] = FALSE;
            $this->load->view('User/login/home', $data);
        }
    }

    public function ViewModelsEditSubmitForm() {

        if ($this->session->userdata('userIsLoggedIn')) {
            $this->load->model('Usermodel');

            //authentication of user
            $data['is_authenticated'] = $this->session->userdata('userIsLoggedIn');
            //user information
            $username = $this->session->userdata('username');
            $data['username'] = $this->session->userdata('username');
            $data['role'] = $this->Usermodel->getRole($username);

            //view the home page
            $this->load->model('ModelsModel');
            $this->load->library('form_validation');
            $error = '';

            $mod_id = stripslashes($_POST['mod_id']);
            $mod_name = stripslashes($_POST['mod_name']);
            $mod_description = stripslashes($_POST['mod_description']);

            $this->form_validation->set_rules('mod_name', 'Title', 'trim|required|xss_clean');
            $this->form_validation->set_rules('mod_description', 'Description', 'trim|required|xss_clean');

            if ($this->form_validation->run() == FALSE) {
                $data['error'] = $error;
                $this->session->set_flashdata('delete_msg', '<div class="alert alert-danger" style="font-size:24px; font:bold;">'
                        . 'Your Model has not been successfully <strong>Edited</strong>!!'
                        . '</div>');
                $data['edit'] = null;
                $this->load->view('pmctoolContent/pmctoolModelsContent/pmctoolModelsContentEdit', $data);
            } else {

                $mod_id = stripslashes($_POST['mod_id']);
                $mod_name = stripslashes($_POST['mod_name']);
                $mod_description = stripslashes($_POST['mod_description']);

                $data = array(
                    'mod_id' => $mod_id,
                    'mod_name' => $mod_name,
                    'mod_description' => $mod_description
                );
                $this->ModelsModel->EditModels($mod_id, $data);
                $this->session->set_flashdata('edit_msg', '<div class="alert alert-success" style="font-size:24px; font:bold;">'
                        . 'Your Model has been successfully <strong>Edited</strong>!!'
                        . '</div>');

                redirect('Models/ViewModels');
            }
        } else {
            //if not authentication the go to Login Page
            $data['is_authenticated'] = FALSE;
            $this->load->view('User/login/home', $data);
        }
    }

    public function ViewModelsDetails($mod_id, $sort_by = 'mod_id', $sort_order = 'desc', $offset = 0) {
        if ($this->session->userdata('userIsLoggedIn')) {
            $this->load->model('Usermodel');

            //authentication of user
            $data['is_authenticated'] = $this->session->userdata('userIsLoggedIn');
            //user information
            $username = $this->session->userdata('username');
            $data['username'] = $this->session->userdata('username');
            $data['role'] = $this->Usermodel->getRole($username);

            //view the home page
            $this->load->model('ModelsModel');
            //pass messages
            $data['gens'] = $this->ModelsModel->getViewModelsDetails($mod_id);
            $limit = 1;
            $results = $this->ModelsModel->searchViewModelsDetails($mod_id, $sort_by, $sort_order, $limit, $offset);
            $data['gen'] = $results['rows'];
            $data['num_result'] = $results['num_rows'];
            //pagination
            $this->load->library('pagination');
            $config = array();
            $config['base_url'] = site_url("Models/ViewModelsDetails/$sort_by/$sort_order");
            $config['total_rows'] = $data['num_result'];
            $config['per_page'] = $limit;
            $config['first_link'] = '&laquo; First ';
            $config['next_link'] = '&gt; Next ';
            $config['prev_link'] = 'Previous &lt; ';
            $config['last_link'] = 'Last &raquo;';
            $config['total_rows'] = $this->db->count_all('model');
            $config['uri_segment'] = 5;
            $this->pagination->initialize($config);
            $data['pagination'] = $this->pagination->create_links();
            $data['fields'] = array(
                'mod_name' => 'Title',
                'mod_description' => 'Description'
            );
            $data['sort_by'] = $sort_by;
            $data['sort_order'] = $sort_order;
            $this->load->view('pmctoolContent/pmctoolModelsContent/pmctoolModelsContentDetails', $data);
        } else {
            //if not authentication the go to Login Page
            $data['is_authenticated'] = FALSE;
            $this->load->model('ModelsModel');
            //pass messages
            $data['gens'] = $this->ModelsModel->getViewModelsDetails($mod_id);
            $limit = 1;
            $results = $this->ModelsModel->searchViewModelsDetails($mod_id, $sort_by, $sort_order, $limit, $offset);
            $data['gen'] = $results['rows'];
            $data['num_result'] = $results['num_rows'];
            //pagination
            $this->load->library('pagination');
            $config = array();
            $config['base_url'] = site_url("Models/ViewModelsDetails/$sort_by/$sort_order");
            $config['total_rows'] = $data['num_result'];
            $config['per_page'] = $limit;
            $config['first_link'] = '&laquo; First ';
            $config['next_link'] = '&gt; Next ';
            $config['prev_link'] = 'Previous &lt; ';
            $config['last_link'] = 'Last &raquo;';
            $config['total_rows'] = $this->db->count_all('model');
            $config['uri_segment'] = 5;
            $this->pagination->initialize($config);
            $data['pagination'] = $this->pagination->create_links();
            $data['fields'] = array(
                'mod_name' => 'Title',
                'mod_description' => 'Description'
            );
            $data['sort_by'] = $sort_by;
            $data['sort_order'] = $sort_order;
            $this->load->view('pmctoolContent/pmctoolModelsContent/pmctoolModelsContentDetails', $data);
        }
    }

    public function ViewModelsAssignFactorCreationForm() {
        if ($this->session->userdata('userIsLoggedIn')) {
            $this->load->model('Usermodel');

            //authentication of user
            $data['is_authenticated'] = $this->session->userdata('userIsLoggedIn');
            //user information
            $username = $this->session->userdata('username');
            $data['username'] = $this->session->userdata('username');
            $data['role'] = $this->Usermodel->getRole($username);

            //view the home page
            //pass messages
            $this->load->model('ModelsModel');
            $data['gModel'] = $this->ModelsModel->getViewModel();
            $data['gComplexityFactor'] = $this->ModelsModel->getViewComplexityFactor();

            $resultsModel = $this->ModelsModel->searchViewModel();
            $resultsComplexityFactor = $this->ModelsModel->searchViewComplexityFactor();

            $data['genModel'] = $resultsModel['rows'];
            $data['genComplexityFactor'] = $resultsComplexityFactor['rows'];

            $data['num_result'] = $resultsModel['num_rows'];
            $data['num_result'] = $resultsComplexityFactor['num_rows'];

            $this->load->view('pmctoolContent/pmctoolModelsContent/pmctoolModelsContentAssignFactor', $data);
        } else {
            //if not authentication the go to Login Page
            $data['is_authenticated'] = FALSE;
            $this->load->view('User/login/home', $data);
        }
    }

    public function CreateModelsAssignFactor() {

        if ($this->session->userdata('userIsLoggedIn')) {
            $this->load->model('Usermodel');

            //authentication of user
            $data['is_authenticated'] = $this->session->userdata('userIsLoggedIn');
            //user information
            $username = $this->session->userdata('username');
            $data['username'] = $this->session->userdata('username');
            $data['role'] = $this->Usermodel->getRole($username);

            //view the home page
            $this->load->model('ModelsModel');
            $this->load->library('form_validation');
            $error = '';

            $this->form_validation->set_rules('mod_id', 'Model', 'trim|required|callback_Select_Model|xss_clean');
            $this->form_validation->set_rules('cf_id', 'Complexity', 'trim|required|callback_Select_Complexity|xss_clean');

            if ($this->form_validation->run() == FALSE) {
                $data['error'] = $error;
                $data['gModel'] = $this->ModelsModel->getViewModel();
                $data['gComplexityFactor'] = $this->ModelsModel->getViewComplexityFactor();

                $resultsModel = $this->ModelsModel->searchViewModel();
                $resultsComplexityFactor = $this->ModelsModel->searchViewComplexityFactor();

                $data['genModel'] = $resultsModel['rows'];
                $data['genComplexityFactor'] = $resultsComplexityFactor['rows'];

                $data['num_result'] = $resultsModel['num_rows'];
                $data['num_result'] = $resultsComplexityFactor['num_rows'];
                $this->load->view('pmctoolContent/pmctoolModelsContent/pmctoolModelsContentAssignFactor', $data);
            } else {
                if ($this->form_validation->run() == TRUE) {

                    $mod_id = stripslashes($_POST['mod_id']);
                    $cf_id = stripslashes($_POST['cf_id']);
                    $data = array(
                        'model_cf_id' => NULL,
                        'mod_id' => $mod_id,
                        'cf_id' => $cf_id
                    );
                    $this->ModelsModel->add_ComplexityToModels($data);

                    $this->session->set_flashdata('success_msg', '<div class="alert alert-success" style="font-size:24px; font:bold;">'
                            . 'Your Complexity has successfully been <strong>Registered</strong> to Model!!'
                            . '</div>');
                    redirect('Models/ViewModels');
                }
            }
        } else {
            //if not authentication the go to Login Page
            $data['is_authenticated'] = FALSE;
            $this->load->view('User/login/home', $data);
        }
    }

    function Select_Model($mod_id) {

        if ($mod_id == "-1") {
            $this->form_validation->set_message('Select_Model', 'You have to select a Model');
            return false;
        } else {
            return true;
        }
    }

    function Select_Complexity($cf_id) {

        if ($cf_id == "-1") {
            $this->form_validation->set_message('Select_Complexity', 'You have to select a Complexity Factor');
            return false;
        } else {
            return true;
        }
    }

    public function ViewModelsAssignments($mod_id, $sort_by = 'mod_id', $sort_order = 'desc', $offset = 0) {
        if ($this->session->userdata('userIsLoggedIn')) {
            $this->load->model('Usermodel');

            //authentication of user
            $data['is_authenticated'] = $this->session->userdata('userIsLoggedIn');
            //user information
            $username = $this->session->userdata('username');
            $data['username'] = $this->session->userdata('username');
            $data['role'] = $this->Usermodel->getRole($username);

            //view the home page
            $this->load->model('ModelsModel');
            //pass messages
            $data['gens'] = $this->ModelsModel->getViewModelsAssignments($mod_id);
            $limit = 10;
            $results = $this->ModelsModel->searchViewModelsAssignments($mod_id, $sort_by, $sort_order, $limit, $offset);
            $data['gen'] = $results['rows'];
            $data['num_result'] = $results['num_rows'];
            //pagination
            $this->load->library('pagination');
            $config = array();
            $config['base_url'] = site_url("Models/ViewModelsAssignments/$sort_by/$sort_order");
            $config['total_rows'] = $data['num_result'];
            $config['per_page'] = $limit;
            $config['first_link'] = '&laquo; First ';
            $config['next_link'] = '&gt; Next ';
            $config['prev_link'] = 'Previous &lt; ';
            $config['last_link'] = 'Last &raquo;';
            $config['total_rows'] = $this->db->count_all('model');
            $config['uri_segment'] = 5;
            $this->pagination->initialize($config);
            $data['pagination'] = $this->pagination->create_links();
            $data['fields'] = array(
                'mod_name' => 'Title',
                'mod_description' => 'Description',
                'cf_name' => 'Complexity Factor Name'
            );
            $data['sort_by'] = $sort_by;
            $data['sort_order'] = $sort_order;
            $this->load->view('pmctoolContent/pmctoolModelsContent/pmctoolModelsContentAssignmentFactor', $data);
        } else {
            //if not authentication the go to Login Page
            $data['is_authenticated'] = FALSE;
            $this->load->model('ModelsModel');
            //pass messages
            $data['gens'] = $this->ModelsModel->getViewModelsAssignments($mod_id);
            $limit = 10;
            $results = $this->ModelsModel->searchViewModelsAssignments($mod_id, $sort_by, $sort_order, $limit, $offset);
            $data['gen'] = $results['rows'];
            $data['num_result'] = $results['num_rows'];
            //pagination
            $this->load->library('pagination');
            $config = array();
            $config['base_url'] = site_url("Models/ViewModelsAssignments/$sort_by/$sort_order");
            $config['total_rows'] = $data['num_result'];
            $config['per_page'] = $limit;
            $config['first_link'] = '&laquo; First ';
            $config['next_link'] = '&gt; Next ';
            $config['prev_link'] = 'Previous &lt; ';
            $config['last_link'] = 'Last &raquo;';
            $config['total_rows'] = $this->db->count_all('model');
            $config['uri_segment'] = 5;
            $this->pagination->initialize($config);
            $data['pagination'] = $this->pagination->create_links();
            $data['fields'] = array(
                'mod_name' => 'Title',
                'mod_description' => 'Description',
                'cf_name' => 'Complexity Factor Name'
            );
            $data['sort_by'] = $sort_by;
            $data['sort_order'] = $sort_order;
            $this->load->view('pmctoolContent/pmctoolModelsContent/pmctoolModelsContentAssignmentFactor', $data);
        }
    }

    public function ViewModelsAssignmentsDetails($model_cf_id, $sort_by = 'model_cf_id', $sort_order = 'desc', $offset = 0) {
        if ($this->session->userdata('userIsLoggedIn')) {
            $this->load->model('Usermodel');

            //authentication of user
            $data['is_authenticated'] = $this->session->userdata('userIsLoggedIn');
            //user information
            $username = $this->session->userdata('username');
            $data['username'] = $this->session->userdata('username');
            $data['role'] = $this->Usermodel->getRole($username);

            //view the home page
            $this->load->model('ModelsModel');
            //pass messages
            $data['gens'] = $this->ModelsModel->getViewModelsAssignmentsDetails($model_cf_id);
            $limit = 10;
            $results = $this->ModelsModel->searchViewModelsAssignmentsDetails($model_cf_id, $sort_by, $sort_order, $limit, $offset);
            $data['gen'] = $results['rows'];
            $data['num_result'] = $results['num_rows'];
            //pagination
            $this->load->library('pagination');
            $config = array();
            $config['base_url'] = site_url("Models/ViewModelsAssignmentsDetails/$sort_by/$sort_order");
            $config['total_rows'] = $data['num_result'];
            $config['per_page'] = $limit;
            $config['first_link'] = '&laquo; First ';
            $config['next_link'] = '&gt; Next ';
            $config['prev_link'] = 'Previous &lt; ';
            $config['last_link'] = 'Last &raquo;';
            $config['total_rows'] = $this->db->count_all('model');
            $config['uri_segment'] = 5;
            $this->pagination->initialize($config);
            $data['pagination'] = $this->pagination->create_links();
            $data['fields'] = array(
                'mod_name' => 'Model Title',
                'mod_description' => 'Model Description',
                'cf_name' => 'Complexity Factor Title',
                'cf_description' => 'Complexity Factor Description',
                'cf_reference' => 'Complexity Factor Reference',
                'cf_restriction' => 'Complexity Factor Restriction',
                'cf_category' => 'Complexity Factor Category',
                'cf_weight' => 'Complexity Factor Weight',
                'metric_name' => 'Metric Title',
                'metric_description' => 'Metric Description',
                'metric_reference' => 'Metric Reference',
                'metric_restriction' => 'Metric Restriction',
                'metric_weight' => 'Metric Weight',
                'evsc_name' => 'Evaluation Scale Title',
                'evsc_description' => 'Evaluation Scale Description',
                'evsc_type' => 'Evaluation Scale Type',
                'evsc_number_of_choices' => 'Evaluation Scale Number of Choices'
            );
            $data['sort_by'] = $sort_by;
            $data['sort_order'] = $sort_order;
            $this->load->view('pmctoolContent/pmctoolModelsContent/pmctoolModelsContentAssignFactorDetails', $data);
        } else {
            //if not authentication the go to Login Page
            $data['is_authenticated'] = FALSE;
            $this->load->model('ModelsModel');
            //pass messages
            $data['gens'] = $this->ModelsModel->getViewModelsAssignmentsDetails($model_cf_id);
            $limit = 10;
            $results = $this->ModelsModel->searchViewModelsAssignmentsDetails($model_cf_id, $sort_by, $sort_order, $limit, $offset);
            $data['gen'] = $results['rows'];
            $data['num_result'] = $results['num_rows'];
            //pagination
            $this->load->library('pagination');
            $config = array();
            $config['base_url'] = site_url("Models/ViewModelsAssignmentsDetails/$sort_by/$sort_order");
            $config['total_rows'] = $data['num_result'];
            $config['per_page'] = $limit;
            $config['first_link'] = '&laquo; First ';
            $config['next_link'] = '&gt; Next ';
            $config['prev_link'] = 'Previous &lt; ';
            $config['last_link'] = 'Last &raquo;';
            $config['total_rows'] = $this->db->count_all('model');
            $config['uri_segment'] = 5;
            $this->pagination->initialize($config);
            $data['pagination'] = $this->pagination->create_links();
            $data['fields'] = array(
                'mod_name' => 'Model Title',
                'mod_description' => 'Model Description',
                'cf_name' => 'Complexity Factor Title',
                'cf_description' => 'Complexity Factor Description',
                'cf_reference' => 'Complexity Factor Reference',
                'cf_restriction' => 'Complexity Factor Restriction',
                'cf_category' => 'Complexity Factor Category',
                'cf_weight' => 'Complexity Factor Weight',
                'metric_name' => 'Metric Title',
                'metric_description' => 'Metric Description',
                'metric_reference' => 'Metric Reference',
                'metric_restriction' => 'Metric Restriction',
                'metric_weight' => 'Metric Weight',
                'evsc_name' => 'Evaluation Scale Title',
                'evsc_description' => 'Evaluation Scale Description',
                'evsc_type' => 'Evaluation Scale Type',
                'evsc_number_of_choices' => 'Evaluation Scale Number of Choices'
            );
            $data['sort_by'] = $sort_by;
            $data['sort_order'] = $sort_order;
            $this->load->view('pmctoolContent/pmctoolModelsContent/pmctoolModelsContentAssignFactorDetails', $data);
        }
    }

    public function ViewModelsAssignmentsDelete($model_cf_id) {

        if ($this->session->userdata('userIsLoggedIn')) {
            $this->load->model('Usermodel');

            //authentication of user
            $data['is_authenticated'] = $this->session->userdata('userIsLoggedIn');
            //user information
            $username = $this->session->userdata('username');
            $data['username'] = $this->session->userdata('username');
            $data['role'] = $this->Usermodel->getRole($username);

            //view the home page
            $this->load->model('ModelsModel');
            $this->ModelsModel->ModelsAssignmentsDelete($model_cf_id);
            $this->session->set_flashdata('delete_msg', '<div class="alert alert-danger" style="font-size:24px; font:bold;">'
                    . 'Your Complexity Factor to Model has successfully been <strong>Deleted</strong>!!'
                    . '</div>');

            redirect('Models/ViewModels');
        } else {
            //if not authentication the go to Login Page
            $data['is_authenticated'] = FALSE;
            $this->load->view('User/login/home', $data);
        }
    }

    public function ViewModelsAssignFactorEditForm($model_cf_id) {
        if ($this->session->userdata('userIsLoggedIn')) {
            $this->load->model('Usermodel');

            //authentication of user
            $data['is_authenticated'] = $this->session->userdata('userIsLoggedIn');
            //user information
            $username = $this->session->userdata('username');
            $data['username'] = $this->session->userdata('username');
            $data['role'] = $this->Usermodel->getRole($username);

            //view the home page
            //pass messages
            $this->load->model('ModelsModel');
            $data['gModel'] = $this->ModelsModel->getViewModelAssignFactor($model_cf_id);
            $data['gComplexityFactor'] = $this->ModelsModel->getViewComplexityFactorAssignFactor($model_cf_id);
            $data['gComplexityFactor1'] = $this->ModelsModel->getViewComplexityFactorAssignFactor1();

            $resultsModel = $this->ModelsModel->searchViewModelAssignFactor($model_cf_id);
            $resultsComplexityFactor = $this->ModelsModel->searchViewComplexityFactorAssignFactor($model_cf_id);
            $resultsComplexityFactor1 = $this->ModelsModel->searchViewComplexityFactorAssignFactor1();

            $data['genModel'] = $resultsModel['rows'];
            $data['genComplexityFactor'] = $resultsComplexityFactor['rows'];
            $data['genComplexityFactor1'] = $resultsComplexityFactor1['rows'];

            $data['num_result'] = $resultsModel['num_rows'];
            $data['num_result'] = $resultsComplexityFactor['num_rows'];
            $data['num_result'] = $resultsComplexityFactor1['num_rows'];

            $this->load->view('pmctoolContent/pmctoolModelsContent/pmctoolModelsContentAssignFactorEditForm', $data);
        } else {
            //if not authentication the go to Login Page
            $data['is_authenticated'] = FALSE;
            $this->load->view('User/login/home', $data);
        }
    }

    public function ViewModelsAssignFactorEditSubmitForm() {

        if ($this->session->userdata('userIsLoggedIn')) {
            $this->load->model('Usermodel');

            //authentication of user
            $data['is_authenticated'] = $this->session->userdata('userIsLoggedIn');
            //user information
            $username = $this->session->userdata('username');
            $data['username'] = $this->session->userdata('username');
            $data['role'] = $this->Usermodel->getRole($username);

            //view the home page
            $this->load->model('ModelsModel');
            $this->load->library('form_validation');
            $error = '';
            $model_cf_id = stripslashes($_POST['model_cf_id']);
            $data['gModel'] = $this->ModelsModel->getViewModelAssignFactor($model_cf_id);
            $data['gComplexityFactor'] = $this->ModelsModel->getViewComplexityFactorAssignFactor($model_cf_id);
            $data['gComplexityFactor1'] = $this->ModelsModel->getViewComplexityFactorAssignFactor1();

            $resultsModel = $this->ModelsModel->searchViewModelAssignFactor($model_cf_id);
            $resultsComplexityFactor = $this->ModelsModel->searchViewComplexityFactorAssignFactor($model_cf_id);
            $resultsComplexityFactor1 = $this->ModelsModel->searchViewComplexityFactorAssignFactor1();

            $data['genModel'] = $resultsModel['rows'];
            $data['genComplexityFactor'] = $resultsComplexityFactor['rows'];
            $data['genComplexityFactor1'] = $resultsComplexityFactor1['rows'];

            $data['num_result'] = $resultsModel['num_rows'];
            $data['num_result'] = $resultsComplexityFactor['num_rows'];
            $data['num_result'] = $resultsComplexityFactor1['num_rows'];

            $this->form_validation->set_rules('mod_id', 'Model', 'trim|required|callback_Select_ModelEdit|xss_clean');
            $this->form_validation->set_rules('cf_id', 'Complexity', 'trim|required|callback_Select_ComplexityEdit|xss_clean');

            if ($this->form_validation->run() == FALSE) {
                $data['error'] = $error;


                $this->load->view('pmctoolContent/pmctoolModelsContent/pmctoolModelsContentAssignFactorEditForm', $data);
            } else {
                if ($this->form_validation->run() == TRUE) {

                    $model_cf_id = stripslashes($_POST['model_cf_id']);
                    $mod_id = stripslashes($_POST['mod_id']);
                    $cf_id = stripslashes($_POST['cf_id']);
                    $data = array(
                        'model_cf_id' => $model_cf_id,
                        'mod_id' => $mod_id,
                        'cf_id' => $cf_id
                    );
                    $this->ModelsModel->edit_ComplexityToModels($model_cf_id, $data);

                    $this->session->set_flashdata('success_msg', '<div class="alert alert-success" style="font-size:24px; font:bold;">'
                            . 'Your Complexity has successfully been <strong>Registered</strong> to Model!!'
                            . '</div>');
                    redirect('Models/ViewModels');
                }
            }
        } else {
            //if not authentication the go to Login Page
            $data['is_authenticated'] = FALSE;
            $this->load->view('User/login/home', $data);
        }
    }

    function Select_ModelEdit($mod_id) {

        if ($mod_id == "-1") {
            $this->form_validation->set_message('Select_ModelEdit', 'You have to select a Model');
            return false;
        } else {
            return true;
        }
    }

    function Select_ComplexityEdit($cf_id) {

        if ($cf_id == "-1") {
            $this->form_validation->set_message('Select_ComplexityEdit', 'You have to select a Complexity Factor');
            return false;
        } else {
            return true;
        }
    }

    public function ViewModelsPDF($mod_id, $sort_by = 'mod_id', $sort_order = 'desc', $offset = 0) {
        if ($this->session->userdata('userIsLoggedIn')) {
            $this->load->model('Usermodel');

            //authentication of user
            $data['is_authenticated'] = $this->session->userdata('userIsLoggedIn');
            //user information
            $username = $this->session->userdata('username');
            $data['username'] = $this->session->userdata('username');
            $data['role'] = $this->Usermodel->getRole($username);

            //view the home page
            $this->load->model('ModelsModel');
            //pass messages
            $data['gens'] = $this->ModelsModel->getViewModelsDetails($mod_id);
            $limit = 1;
            $results = $this->ModelsModel->searchViewModelsDetails($mod_id, $sort_by, $sort_order, $limit, $offset);
            $data['gen'] = $results['rows'];
            $data['num_result'] = $results['num_rows'];
            $now = new DateTime();
            $data['today'] = $now->format('d-m-Y H:i:s');
            $this->load->view('pdf/Model', $data);
        } else {
            //if not authentication the go to Login Page
            $data['is_authenticated'] = FALSE;
            $this->load->model('ModelsModel');
            //pass messages
            $data['gens'] = $this->ModelsModel->getViewModelsDetails($mod_id);
            $limit = 1;
            $results = $this->ModelsModel->searchViewModelsDetails($mod_id, $sort_by, $sort_order, $limit, $offset);
            $data['gen'] = $results['rows'];
            $data['num_result'] = $results['num_rows'];
            $now = new DateTime();
            $data['today'] = $now->format('d-m-Y H:i:s');
            $this->load->view('pdf/Model', $data);
        }
    }

    public function ViewModelsAssignmentsPDF($model_cf_id, $sort_by = 'model_cf_id', $sort_order = 'desc', $offset = 0) {
        if ($this->session->userdata('userIsLoggedIn')) {
            $this->load->model('Usermodel');

            //authentication of user
            $data['is_authenticated'] = $this->session->userdata('userIsLoggedIn');
            //user information
            $username = $this->session->userdata('username');
            $data['username'] = $this->session->userdata('username');
            $data['role'] = $this->Usermodel->getRole($username);

            //view the home page
            $this->load->model('ModelsModel');
            //pass messages
            $data['gens'] = $this->ModelsModel->getViewModelsAssignmentsDetails($model_cf_id);
            $limit = 10;
            $results = $this->ModelsModel->searchViewModelsAssignmentsDetails($model_cf_id, $sort_by, $sort_order, $limit, $offset);
            $data['gen'] = $results['rows'];
            $data['num_result'] = $results['num_rows'];

            $data['fields'] = array(
                'mod_name' => 'Model Title',
                'mod_description' => 'Model Description',
                'cf_name' => 'Complexity Factor Title',
                'cf_description' => 'Complexity Factor Description',
                'cf_reference' => 'Complexity Factor Reference',
                'cf_restriction' => 'Complexity Factor Restriction',
                'cf_category' => 'Complexity Factor Category',
                'cf_weight' => 'Complexity Factor Weight',
                'metric_name' => 'Metric Title',
                'metric_description' => 'Metric Description',
                'metric_reference' => 'Metric Reference',
                'metric_restriction' => 'Metric Restriction',
                'metric_weight' => 'Metric Weight',
                'evsc_name' => 'Evaluation Scale Title',
                'evsc_description' => 'Evaluation Scale Description',
                'evsc_type' => 'Evaluation Scale Type',
                'evsc_number_of_choices' => 'Evaluation Scale Number of Choices'
            );
            $now = new DateTime();
            $data['today'] = $now->format('d-m-Y H:i:s');
            $this->load->view('pdf/ModelsAssignments', $data);
        } else {
            //if not authentication the go to Login Page
            $data['is_authenticated'] = FALSE;
            $this->load->model('ModelsModel');
            //pass messages
            $data['gens'] = $this->ModelsModel->getViewModelsAssignmentsDetails($model_cf_id);
            $limit = 10;
            $results = $this->ModelsModel->searchViewModelsAssignmentsDetails($model_cf_id, $sort_by, $sort_order, $limit, $offset);
            $data['gen'] = $results['rows'];
            $data['num_result'] = $results['num_rows'];

            $data['fields'] = array(
                'mod_name' => 'Model Title',
                'mod_description' => 'Model Description',
                'cf_name' => 'Complexity Factor Title',
                'cf_description' => 'Complexity Factor Description',
                'cf_reference' => 'Complexity Factor Reference',
                'cf_restriction' => 'Complexity Factor Restriction',
                'cf_category' => 'Complexity Factor Category',
                'cf_weight' => 'Complexity Factor Weight',
                'metric_name' => 'Metric Title',
                'metric_description' => 'Metric Description',
                'metric_reference' => 'Metric Reference',
                'metric_restriction' => 'Metric Restriction',
                'metric_weight' => 'Metric Weight',
                'evsc_name' => 'Evaluation Scale Title',
                'evsc_description' => 'Evaluation Scale Description',
                'evsc_type' => 'Evaluation Scale Type',
                'evsc_number_of_choices' => 'Evaluation Scale Number of Choices'
            );
            $now = new DateTime();
            $data['today'] = $now->format('d-m-Y H:i:s');
            $this->load->view('pdf/ModelsAssignments', $data);
        }
    }

}
