<?php
class ItemsController extends Controller {

    function view($id = null, $name = null) {
        $this->set('title', $name . ' - My Todo List App');
        $this->set('todo', $this->_model->select($id));
    }
    function viewall() {

        echo"view all called";

        $this->set('title', 'All Items - My Todo List App');
        $this->set('todo', $this->_model->selectAll());
    }
    function add() {
        $todo = $_POST['todo'];
        $query = "INSERT INTO items (item_name) VALUES (?)";
        $this->_model->query($query, 0, [$todo]);
        $this->set('title', 'Success - My Todo List App');
        $this->set('todo', 'Item added successfully');
    }
    function delete($id = null) {
        $query = "DELETE FROM items WHERE id = ?";
        $this->_model->query($query, 0, [$id]);
        $this->set('title', 'Success - My Todo List App');
        $this->set('todo', 'Item deleted successfully');
    }
}