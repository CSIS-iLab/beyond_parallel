<?php

class tzTodo {

    protected $option_name = 'tz-todo';
	
    protected $data = array(
        'url_todo' => 'todo',
        'title_todo' => 'Todo List'
    );

    public function __construct() {

        add_action('init', array($this, 'init'));
        add_filter("manage_tz_todo_posts_columns", array($this, 'change_columns'));

        // The two last optional arguments to this function are the 
        // priority (10) and number of arguments that the function expects (2):
        add_action("manage_posts_custom_column", array($this, "custom_columns"), 10, 2);

        // These hooks will handle AJAX interactions. We need to handle
        // ajax requests from both logged in users and anonymous ones:
        add_action('wp_ajax_nopriv_tz_ajax', array($this, 'ajax'));
        add_action('wp_ajax_tz_ajax', array($this, 'ajax'));

        // Admin sub-menu
        add_action('admin_init', array($this, 'admin_init'));
        add_action('admin_menu', array($this, 'add_page'));

        // Listen for the activate event
        register_activation_hook(TZ_TODO_FILE, array($this, 'activate'));

        // Deactivation plugin
        register_deactivation_hook(TZ_TODO_FILE, array($this, 'deactivate'));
    }

    public function activate() {
        update_option($this->option_name, $this->data);
    }

    public function deactivate() {
        delete_option($this->option_name);
    }
	
    public function init() {

        // When a URL like /todo is requested from the,
        // blog (the URL is customizable) we will directly
        // include the index.php file of the application and exit
        $result = get_option('tz-todo');
        
        if (preg_match('/\/' . preg_quote($result['url_todo']) . '\/?$/', $_SERVER['REQUEST_URI'])) {
        	
			// This will show the stylesheet in wp_head() in the app/index.php file
	        wp_enqueue_style('stylesheet', plugins_url('tz-todoapp/app/assets/css/styles.css'));        
	
			// This will show the scripts in the footer
	        wp_deregister_script('jquery');
	        wp_enqueue_script('jquery', 'http://code.jquery.com/jquery-1.8.2.min.js', array(), false, true);
	        wp_enqueue_script('script', plugins_url('tz-todoapp/app/assets/js/script.js'), array('jquery'), false, true);
			
            require TZ_TODO_PATH . '/app/index.php';
            exit;
        }

        $this->add_post_type();
    }

    // White list our options using the Settings API
    public function admin_init() {
        register_setting('todo_list_options', $this->option_name, array($this, 'validate'));
    }

    // Add entry in the settings menu
    public function add_page() {
        add_options_page('Todo  Options', 'Todo Options', 'manage_options', 'todo_list_options', array($this, 'options_do_page'));
    }

    // Print the menu page itself
    public function options_do_page() {
        $options = get_option($this->option_name);
        ?>
        <div class="wrap">
            <h2>Todo List Options</h2>
            <form method="post" action="options.php">
                <?php settings_fields('todo_list_options'); ?>
                <table class="form-table">
                    <tr valign="top"><th scope="row">App URL:</th>
                        <td><input type="text" name="<?php echo $this->option_name?>[url_todo]" value="<?php echo $options['url_todo']; ?>" /></td>
                    </tr>
                    <tr valign="top"><th scope="row">Title:</th>
                        <td><input type="text" name="<?php echo $this->option_name?>[title_todo]" value="<?php echo $options['title_todo']; ?>" /></td>
                    </tr>
                </table>
                <p class="submit">
                    <input type="submit" class="button-primary" value="<?php _e('Save Changes') ?>" />
                </p>
            </form>
        </div>
        <?php
    }

    public function validate($input) {

        $valid = array();
        $valid['url_todo'] = sanitize_text_field($input['url_todo']);
        $valid['title_todo'] = sanitize_text_field($input['title_todo']);

        if (strlen($valid['url_todo']) == 0) {
            add_settings_error(
                    'todo_url', 					// setting title
                    'todourl_texterror',			// error ID
                    'Please enter a valid URL',		// error message
                    'error'							// type of message
            );
			
			# Set it to the default value
			$valid['url_todo'] = $this->data['url_todo'];
        }
        if (strlen($valid['title_todo']) == 0) {
            add_settings_error(
                    'todo_title',
                    'todotitle_texterror',
                    'Please enter a title',
                    'error'
            );
			
			$valid['title_todo'] = $this->data['title_todo'];
        }
		
        return $valid;
    }
	

    // This method is called when an
    // AJAX request is made to the plugin

    public function ajax() {
        $id = -1;
        $data = '';
        $verb = '';

        $response = array();

        if (isset($_POST['verb'])) {
            $verb = $_POST['verb'];
        }

        if (isset($_POST['id'])) {
            $id = (int) $_POST['id'];
        }

        if (isset($_POST['data'])) {
            $data = wp_strip_all_tags($_POST['data']);
        }

        $post = null;

        if ($id != -1) {
            $post = get_post($id);

            // Make sure that the passed id actually
            // belongs to a post of the tz_todo type

            if ($post && $post->post_type != 'tz_todo') {
                exit;
            }
        }

        switch ($verb) {
            case 'save':

                $todo_item = array(
                    'post_title' => $data,
                    'post_content' => '',
                    'post_status' => 'publish',
                    'post_type' => 'tz_todo',
                );

                if ($post) {

                    // Adding an id to the array will cause 
                    // the post with that id to be edited
                    // instead of a new entry to be created.

                    $todo_item['ID'] = $post->ID;
                }

                $response['id'] = wp_insert_post($todo_item);
                break;

            case 'check':

                if ($post) {
                    update_post_meta($post->ID, 'status', 'Completed');
                }

                break;

            case 'uncheck':

                if ($post) {
                    delete_post_meta($post->ID, 'status');
                }

                break;

            case 'delete':
                if ($post) {
                    wp_delete_post($post->ID);
                }
                break;
        }

        // Print the response as json and exit
        header("Content-type: application/json");
        die(json_encode($response));
    }

    private function add_post_type() {

        // The register_post_type function
        // will make a new Todo item entry
        // in the wordpress admin menu

        register_post_type('tz_todo', array(
            'labels' => array(
                'name' => __('Todo items'),
                'singular_name' => __('Todo item')
            ),
            'public' => true,
            'supports' => array('title') // Only a title is allowed for this type
                )
        );
    }

    public function change_columns($cols) {

        // We need to customize the columns 
        // shown when viewing the Todo items
        // post type to include a status field

        $cols = array(
            'cb' => '<input type="checkbox" />',
            'title' => __('Task'),
            'status' => __('Status'),
            'date' => __('Date'),
        );

        return $cols;
    }

    public function custom_columns($column, $post_id) {

        // Add content to the status column

        switch ($column) {

            case "status":
                // We are requesting the status meta item

                $status = get_post_meta($post_id, 'status', true);

                if ($status != 'Completed') {
                    $status = 'Not completed';
                }

                echo $status;

                break;
        }
    }

}
