<?php
class ControllerModuleNvrbadsite extends Controller {
	private $error = array(); 

	public function index() {   
        $this->language->load('module/nvrbadsite');

		$this->document->setTitle($this->language->get('heading_title'));

        $this->getList();
		
    }

    public function insert()
	{
		$this->language->load('module/nvrbadsite');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('module/nvrbadsite');

        
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
          
			$this->model_module_nvrbadsite->insert($this->request->post);

		    $this->session->data['success'] = $this->language->get('text_success');

		 	$url = '';

			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}

			$this->redirect($this->url->link('module/nvrbadsite', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		 }

		$this->getForm();
	}

    public function update()
	{
		$this->language->load('module/nvrbadsite');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('module/nvrbadsite');

        
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
          
			$this->model_module_nvrbadsite->update($this->request->get['id'], $this->request->post);

		    $this->session->data['success'] = $this->language->get('text_success');

		 	$url = '';

			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}

			$this->redirect($this->url->link('module/nvrbadsite', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		 }

		$this->getForm();
	}

    public function delete()
	{
   
		$this->language->load('module/nvrbadsite');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('module/nvrbadsite');

		if (isset($this->request->post['selected']) && $this->validateDelete()) {
			foreach ($this->request->post['selected'] as $id) {
				$this->model_module_nvrbadsite->deleteRecord($id);
			}

			$this->session->data['success'] = $this->language->get('text_success');

			$url = '';

			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}

			$this->redirect($this->url->link('module/nvrbadsite', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		}

		$this->getList();
	}

    protected function getList(){

        if (isset($this->request->get['page'])) {
			$page = $this->request->get['page'];
		} else {
			$page = 1;
		}

        $this->data['page'] = $page;

        $this->data['heading_title'] = $this->language->get('heading_title');

		$this->data['text_enabled'] = $this->language->get('text_enabled');
		$this->data['text_disabled'] = $this->language->get('text_disabled');
		$this->data['text_content_top'] = $this->language->get('text_content_top');
		$this->data['text_content_bottom'] = $this->language->get('text_content_bottom');		
		$this->data['text_no_results'] = $this->language->get('text_no_results');

		$this->data['entry_description'] = $this->language->get('entry_description');
		$this->data['entry_layout'] = $this->language->get('entry_layout');
		$this->data['entry_position'] = $this->language->get('entry_position');
		$this->data['entry_status'] = $this->language->get('entry_status');
		$this->data['entry_sort_order'] = $this->language->get('entry_sort_order');

        $this->data['column_site_url'] = $this->language->get('column_site_url');
		
		$this->data['button_insert'] = $this->language->get('button_insert');
		$this->data['button_delete'] = $this->language->get('button_delete');

		$this->data['breadcrumbs'] = array();

		$this->data['breadcrumbs'][] = array(
			'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
			'separator' => false
		);

		$this->data['breadcrumbs'][] = array(
			'text'      => $this->language->get('text_module'),
			'href'      => $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL'),
			'separator' => ' :: '
		);

		$this->data['breadcrumbs'][] = array(
			'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('module/nvrbadsite', 'token=' . $this->session->data['token'], 'SSL'),
			'separator' => ' :: '
		);

        $url = "";

		$this->data['insert'] = $this->url->link('module/nvrbadsite/insert', 'token=' . $this->session->data['token'] . $url, 'SSL');
		$this->data['delete'] = $this->url->link('module/nvrbadsite/delete', 'token=' . $this->session->data['token'] . $url, 'SSL');

		$this->data['token'] = $this->session->data['token'];

		$this->load->model('localisation/language');

		$this->data['languages'] = $this->model_localisation_language->getLanguages();

        $this->load->model('module/nvrbadsite');

        $data = array(
			'start'           => ($page - 1) * $this->config->get('config_admin_limit'),
			'limit'           => $this->config->get('config_admin_limit')
		);

        $records = $this->model_module_nvrbadsite->getRecords($data);
        $records_total = $this->model_module_nvrbadsite->getTotalRecords($data);
       
        foreach ($records as $result) {
			$action = array();

			$action[] = array(
				'text' => $this->language->get('text_edit'),
				'href' => $this->url->link('module/nvrbadsite/update', 'token=' . $this->session->data['token'] . '&id=' . $result['id'] . $url, 'SSL')
			);

			$this->data['records'][] = array(
				'id' => $result['id'],
				'url'   => $result['url'],
				'description'	=> $result['description'],
                'action'     => $action
			);
		}

        $pagination = new Pagination();
		$pagination->total = $records_total;
		$pagination->page = $page;
		$pagination->limit = $this->config->get('config_admin_limit');
		$pagination->text = $this->language->get('text_pagination');
		$pagination->url = $this->url->link('module/nvrbagsite', 'token=' . $this->session->data['token'] . $url . '&page={page}', 'SSL');

		$this->data['pagination'] = $pagination->render();

        $this->template = 'module/nvrbadsite.tpl';
		$this->children = array(
			'common/header',
			'common/footer'
		);

		$this->response->setOutput($this->render());
    }

    protected function getForm()
	{
        
		$this->data['heading_title'] = $this->language->get('heading_title');
        $this->data['tab_general'] = $this->language->get('tab_general');
		$this->data['text_enabled'] = $this->language->get('text_enabled');
        $this->data['entry_site_url'] = $this->language->get('entry_site_url');
        $this->data['entry_description'] = $this->language->get('entry_description');
        
        $this->data['button_save'] = $this->language->get('button_save');
		$this->data['button_cancel'] = $this->language->get('button_cancel');

        $this->load->model('localisation/language');
        $this->data['languages'] = $this->model_localisation_language->getLanguages();

        $url = "";

        if (isset($this->error['warning'])) {
			$this->data['error_warning'] = $this->error['warning'];
		} else {
			$this->data['error_warning'] = '';
		}

        if (isset($this->error['url'])) {
			$this->data['error_site_url'] = $this->error['url'];
		} else {
			$this->data['error_site_url'] = array();
		}

        if (isset($this->error['description'])) {
			$this->data['error_description'] = $this->error['description'];
		} else {
			$this->data['error_description'] = array();
		}



        $this->data['breadcrumbs'] = array();

		$this->data['breadcrumbs'][] = array(
			'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
			'separator' => false
		);

		$this->data['breadcrumbs'][] = array(
			'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('module/nvrbadsite', 'token=' . $this->session->data['token'] . $url, 'SSL'),
			'separator' => ' :: '
		);

        if (isset($this->request->post['nvrbadsite_description'])) {
			$this->data['nvrbadsite_description'] = $this->request->post['nvrbadsite_description'];
		} elseif (isset($this->request->get['id'])) {
			$this->data['nvrbadsite_description'] = $this->model_module_nvrbadsite->getRecord($this->request->get['id']);
		} else {
			$this->data['nvrbadsite_description'] = array();
		}

        if(!isset($this->request->get['id'])) {
			$this->data['action'] = $this->url->link('module/nvrbadsite/insert', 'token=' . $this->session->data['token'] . $url, 'SSL');
		} else {
			$this->data['action'] = $this->url->link('module/nvrbadsite/update', 'token=' . $this->session->data['token'] . '&id=' . $this->request->get['id'] . $url, 'SSL');
		}

        $this->data['cancel'] = $this->url->link('module/nvrbadsite', 'token=' . $this->session->data['token'] . $url, 'SSL');

        $this->template = 'module/nvrbadsite_form.tpl';
		$this->children = array(
			'common/header',
			'common/footer'
		);

		$this->response->setOutput($this->render());

    }

    protected function validateDelete(){
        if (!$this->user->hasPermission('modify', 'module/nvrbadsite')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		if (!$this->error) {
			return true;
		} else {
			return false;
		}
    }

    protected function validateForm(){
        $this->load->model('module/nvrbadsite');

        if (!$this->user->hasPermission('modify', 'module/nvrbadsite')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}
       
		foreach ($this->request->post['nvrbadsite_description'] as $language_id => $value) {
			if ((utf8_strlen($value['url']) < 1)) {
				$this->error['url'][$language_id] = $this->language->get('error_site_url');
			}

            if ((utf8_strlen($value['url']) > 1 && !empty($this->model_module_nvrbadsite->getRecordByUrl($value['url'])))) {
				$this->error['url'][$language_id] = $this->language->get('error_site_exists');
			}

            if ((utf8_strlen($value['description']) < 1)) {
				$this->error['description'][$language_id] = $this->language->get('error_description');
			}
		}

		if ($this->error && !isset($this->error['warning'])) {
			$this->error['warning'] = $this->language->get('error_warning');
		}

		if (!$this->error) {
			return true;
		} else {
			return false;
		}
    }

    public function install(){
        $this->db->query("CREATE TABLE ".DB_PREFIX."nvrbadsite (
            id INT AUTO_INCREMENT PRIMARY KEY,
            language_id INT,
            url VARCHAR(255),
            description TEXT
        );");
    }
}