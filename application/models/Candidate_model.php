<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * User_model class.
 *
 * @extends CI_Model
 */
class Candidate_model extends CI_Model
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
        $this->load->database();
    }

    /**
     * create_candidate function.
     *
     * @access public
     * @param string $name
     * @param string $email
     * @param string $contact
     * @param float $amount
     * @return bool true on success, false on failure
     */
    public function create_candidate($name, $email, $contact, $amount)
    {
        $data = array(
            'name' => $name,
            'email' => $email,
            'contact_number' => $contact,
            'amount' => $amount,
            'created_at' => date('Y-m-j H:i:s'),
        );

        return $this->db->insert('candidateS', $data);
    }

    /**
     * get_candidates with pagination function.
     *
     * @access public
     * @return object the candidate list
     */
    public function get_candidates()
    {
        $this->db->from('candidates');
        $this->db->limit(QUERY_LIMIT);
        return $this->db->get()->row();
    }

    function get_candidate_list($post)
    {
        $this->_get_candidate_list_query($post);
        if ($post['length'] != -1) {
            $this->db->limit($post['length'], $post['start']);
        }
        $query = $this->db->get();
        return $query->result();
    }

    function _get_candidate_list_query($post)
    {
        $this->db->select("*");
        $this->db->from('candidates');

        if(!empty($post['where'])){
            $this->db->where($post['where']);
        }

        if (!empty($post['search_value'])) {
            $like = "";
            foreach ($post['column_search'] as $key => $item) { // loop column
                // if datatable send POST for search
                if ($key === 0) { // first loop
                    $like .= "( " . $item . " LIKE '%" . $post['search_value'] . "%' ";

                } else {
                    $like .= " OR " . $item . " LIKE '%" . $post['search_value'] . "%' ";

                }
            }
            $like .= ") ";

            $this->db->where($like, null, false);
        }

        if (!empty($post['candidate'])) { // here order processing

            $this->db->order_by($post['column_order'][$post['order'][0]['column']], $post['order'][0]['dir']);

        } else if (isset($this->order)) {
            $order = $this->order;
            $this->db->order_by(key($order), $order[key($candidate)]);

        }
    }

    function count_all($post)
    {
        $this->_count_all_bb_candidate($post);
        $query = $this->db->count_all_results();

        return $query;
    }

    public function _count_all_bb_candidate($post)
    {
        $this->db->from('candidates');
    }

    function count_filtered($post)
    {
        $this->_get_candidate_list_query($post);

        $query = $this->db->get();
        return $query->num_rows();
    }

    /**
     * get_candidate by id function.
     *
     * @access public
     * @param mixed $cand_id
     * @return object the user object
     */
    public function get_candidate($cand_id)
    {
        $this->db->from('candidates');
        $this->db->where('id', $cand_id);
        return $this->db->get()->row();
    }
}
