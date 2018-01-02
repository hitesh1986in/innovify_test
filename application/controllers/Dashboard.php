<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Dashboard class.
 *
 * @extends CI_Controller
 */
class Dashboard extends CI_Controller
{
    /**
     * __construct function.
     *
     * @access public
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        $this->load->library(array('session'));
        $this->load->helper(array('url'));
        $this->load->model(array('user_model', 'candidate_model'));

    }

    public function index()
    {
        $this->load->view('header');
        $this->load->view('dashboard/candidate_list');
        //$this->load->view('footer');
    }

    public function add()
    {
        // create the data object
        $data = new stdClass();

        // load form helper and validation library
        $this->load->helper('form');
        $this->load->library('form_validation');

        // set validation rules
        $this->form_validation->set_rules('name', 'Name', 'required');
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
        $this->form_validation->set_rules('contact', 'Contact Number', 'required');
        $this->form_validation->set_rules('amount', 'Payable to Candidate amount', 'required|numeric');

        if ($this->form_validation->run() == false) {
            // validation not ok, send validation errors to the view
            $this->load->view('header');
            $this->load->view('dashboard/candidate_add');
            $this->load->view('footer');
        } else {
            // set variables from the form
            $name = $this->input->post('name');
            $email = $this->input->post('email');
            $contact = $this->input->post('contact');
            $amount = $this->input->post('amount');

            if ($this->candidate_model->create_candidate($name, $email, $contact, $amount)) {
                redirect('dashboard');
            } else {
                // login failed
                $data->error = 'Some issue to add candidate';

                // send error to the view
                $this->load->view('header');
                $this->load->view('dashboard/candidate_add', $data);
                $this->load->view('footer');
            }
        }

    }

    function getdata()
    {
        // log_message("info",  json_encode($_POST));
        $data = $this->process_get_data();
        $post = $data['post'];
        $output = array(
            "draw" => $post['draw'],
            "recordsTotal" => $this->candidate_model->count_all($post),
            "recordsFiltered" => $this->candidate_model->count_filtered($post),
            "data" => $data['data'],
        );
        unset($post);
        unset($data);
        echo json_encode($output);

    }

    function process_get_data()
    {
        $post = $this->get_post_input_data();

        $post['column_order'] = array( NULL, 'name', 'email', 'contact_number', NULL, NULL, NULL, 'amount');
        $post['column_search'] = array('name');

        $list = $this->candidate_model->get_candidate_list($post);
        $data = array();
        $no = $post['start'];

        foreach ($list as $candidate_model_list) {
            $no++;
            $row = $this->candidate_model_table_data($candidate_model_list, $no);
            $data[] = $row;
        }

        return array(
            'data' => $data,
            'post' => $post
        );
    }

    function get_post_input_data()
    {
        $post['length'] = $this->input->post('length');
        $post['start'] = $this->input->post('start');
        $search = $this->input->post('search');
        $post['search_value'] = $search['value'];
        $post['candidate_model'] = $this->input->post('candidate_model');
        $post['draw'] = $this->input->post('draw');
        $post['status'] = $this->input->post('status');

        return $post;
    }

    function candidate_model_table_data($candidate_list, $no)
    {
        $row = array();
        $innovify_service_tax = $candidate_list->amount * INNOVIFY_ST;
        $innovify_VAT = $candidate_list->amount * INNOVIFY_VAT;
        $row[] = $no;
        $row[] = "<a href='javascript:void(0)'>$candidate_list->name</a>";

        $row[] = $candidate_list->email;
        $row[] = $candidate_list->contact_number;
        $row[] = $candidate_list->amount;
        $row[] = $innovify_service_tax;
        $row[] = $innovify_VAT;
        $row[] = $candidate_list->amount + $innovify_service_tax + $innovify_VAT;

        return $row;
    }

}



