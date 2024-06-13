<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Books extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->helper(array('form', 'url', 'cors'));
        enable_cors(); // Enable CORS
        $this->load->model('Book_model');
        $this->load->library('form_validation');
    }

    // public function test() {
    //     echo "Test route is working!";
    // }

    public function index() {
        $this->get_books(); // list all books
    }

    public function get_books() { // list all books
        $data['books'] = $this->Book_model->get_books();
        echo json_encode($data['books']);
    }

    public function create_book() {
        $input = json_decode(trim(file_get_contents('php://input')), true);

        // Set validation rules
        $this->form_validation->set_data($input);
        $this->form_validation->set_rules('title', 'Title', 'required');
        $this->form_validation->set_rules('author', 'Author', 'required|callback_author_check');
        $this->form_validation->set_rules('genre', 'Genre', 'required');
        $this->form_validation->set_rules('published_year', 'Published Year', 'required|numeric');
        $this->form_validation->set_rules('description', 'Description', 'required|min_length[100]');

        if ($this->form_validation->run() == FALSE) {
            // Validation failed
            $this->output
                ->set_status_header(400)
                ->set_output(json_encode(['error' => validation_errors()]));
            return;
        }

        $data = [
            'title' => $input['title'],
            'author' => $input['author'],
            'genre' => $input['genre'],
            'published_year' => $input['published_year'],
            'description' => $input['description']
        ];

        $result = $this->Book_model->create_book($data);

        if ($result) {
            // Success
            $this->output
                ->set_status_header(201)
                ->set_output(json_encode(['message' => 'Book created successfully']));
        } else {
            // Error
            $this->output
                ->set_status_header(500)
                ->set_output(json_encode(['error' => 'An error occurred while creating the book']));
        }
    }

    public function handle_book($id) {
        $method = $_SERVER['REQUEST_METHOD'];

        switch ($method) {
            case 'GET':
                $this->get_book($id);
                break;
            case 'POST':
                $this->update_book($id);
                break;
            default:
                $this->output
                    ->set_status_header(405)
                    ->set_output(json_encode(['error' => 'Method not allowed']));
                break;
        }
    }

    public function get_book($id) {
        $data['book'] = $this->Book_model->get_book($id);
        echo json_encode($data['book']);
    }

    public function update_book($id) {         
        $input = json_decode(trim(file_get_contents('php://input')), true);

        // Set validation rules
        $this->form_validation->set_data($input);
        $this->form_validation->set_rules('title', 'Title', 'required');
        $this->form_validation->set_rules('author', 'Author', 'required|callback_author_check');
        $this->form_validation->set_rules('genre', 'Genre', 'required');
        $this->form_validation->set_rules('published_year', 'Published Year', 'required|numeric');
        $this->form_validation->set_rules('description', 'Description', 'required|min_length[100]');

        if ($this->form_validation->run() == FALSE) {
            // Validation failed
            $this->output
                ->set_status_header(400)
                ->set_output(json_encode(['error' => validation_errors()]));
            return;
        }

        $data = [
            'title' => $input['title'],
            'author' => $input['author'],
            'genre' => $input['genre'],
            'published_year' => $input['published_year'],
            'description' => $input['description']
        ];

        $result = $this->Book_model->update_book($id, $data);

        if ($result) {
            // Success
            $this->output
                ->set_status_header(200)
                ->set_output(json_encode(['message' => 'Book updated successfully']));
        } else {
            // Error
            $this->output
                ->set_status_header(500)
                ->set_output(json_encode(['error' => 'An error occurred while updating the book']));
        }
    }
    

    public function delete_book($id) {
        $result = $this->Book_model->delete_book($id);

        if ($result) {
            // Success
            $this->output
                ->set_status_header(200)
                ->set_output(json_encode(['message' => 'Book deleted successfully']));
        } else {
            // Error
            $this->output
                ->set_status_header(500)
                ->set_output(json_encode(['error' => 'An error occurred while deleting the book']));
        }
    }

    // Custom validation callback for author
    public function author_check($str) {
        if (preg_match("/^[a-zA-Z]+ [a-zA-Z]+$/", $str)) {
            return TRUE;
        } else {
            $this->form_validation->set_message('author_check', 'The {field} field must contain a first name and a last name.');
            return FALSE;
        }
    }
}

