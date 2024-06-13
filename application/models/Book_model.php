<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Book_model extends CI_Model {

    // Constructor to load the database
    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    // Retrieve all books
    public function get_books() {
        $query = $this->db->get('books');
        return $query->result_array();
    }

    // Retrieve a book by id
    public function get_book($id) {
        $query = $this->db->get_where('books', array('id' => $id));
        return $query->row_array();
    }

    // Insert a new book
    public function create_book($data) {
        return $this->db->insert('books', $data);
    }

    // Update a book by id
    public function update_book($id, $data) {
        $this->db->where('id', $id);
        return $this->db->update('books', $data);
    }

    // Delete a book by id
    public function delete_book($id) {
        $this->db->where('id', $id);
        return $this->db->delete('books');
    }
}
