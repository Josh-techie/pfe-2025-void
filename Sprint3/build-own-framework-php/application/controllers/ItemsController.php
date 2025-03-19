<?php

class ItemsController extends Controller {

	function view($id = null, $name = null) {

		$this->set('title', $name . ' - My Todo List App');
		$this->set('todo', $this->_model->select($id));  // Assuming you have a select() method in your Model
	}

	function viewall() {

		$this->set('title', 'All Items - My Todo List App');
		$this->set('todos', $this->_model->selectAll()); //plural name to avoid confusion
	}

	function add() {
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			$todo = $_POST['todo'];

			if (!empty($todo)) {
				// Sanitize the input (crucial for security!)
				$todo = $this->_model->escapeString($todo);  // Use the Model's escape method

				$result = $this->_model->query("INSERT INTO items (item_name) VALUES ('" . $todo . "')");

				if ($result) {
					$this->set('title', 'Success - My Todo List App');
					$this->set('message', 'Item added successfully.');  // Provide feedback
					// Redirect to viewall (optional, better UX)
					header("Location: /items/viewall"); // Adjust the path as needed. IMPORTANT - this needs to be before any output to work
					exit;
				} else {
					$this->set('title', 'Error - My Todo List App');
					$this->set('message', 'Error adding item.');
				}

			} else {
				$this->set('title', 'Error - My Todo List App');
				$this->set('message', 'Item name cannot be empty.');
			}
		} else {
			// Handle GET request to the add page (display a form).  You'll need an add.php view.
			$this->set('title', 'Add Item - My Todo List App');
		}
		//No need to set todo after the query is run

	}

	function delete($id = null) {
		if ($id !== null) {
			// Sanitize the input (crucial for security!)
			$id = $this->_model->escapeString($id);

			$result = $this->_model->query("DELETE FROM items WHERE id = '" . $id . "'");

			if ($result) {
				$this->set('title', 'Success - My Todo List App');
				$this->set('message', 'Item deleted successfully.');
				// Redirect to viewall (optional, better UX)
				header("Location: /items/viewall"); // Adjust the path as needed. IMPORTANT - this needs to be before any output to work
				exit;
			} else {
				$this->set('title', 'Error - My Todo List App');
				$this->set('message', 'Error deleting item.');
			}
		} else {
			$this->set('title', 'Error - My Todo List App');
			$this->set('message', 'No item ID provided for deletion.');
		}
	}
}
?>