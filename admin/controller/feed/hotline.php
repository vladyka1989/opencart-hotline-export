<?php

/**
 * OpenCart Ukrainian Community
 * This Product Made in Ukraine
 *
 * LICENSE
 *
 * This source file is subject to the GNU General Public License, Version 3
 * It is also available through the world-wide-web at this URL:
 * http://www.gnu.org/copyleft/gpl.html
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email

 *
 * @category   OpenCart
 * @package    OCU Hotline gnupg_export(identifier, fingerprint)
 * @copyright  Copyright (c) 2011 Eugene Lifescale (a.k.a. Shaman) by OpenCart Ukrainian Community (http://opencart-ukraine.tumblr.com)
 * @license    http://www.gnu.org/copyleft/gpl.html     GNU General Public License, Version 3
 * @version    $Id: catalog/model/shipping/ocu_ukrposhta.php 1.2 2011-12-11 22:34:40
 */

/**
 * @category   OpenCart
 * @package    OCU OCU Hotline Export
 * @copyright  Copyright (c) 2011 Eugene Lifescale (a.k.a. Shaman) by OpenCart Ukrainian Community (http://opencart-ukraine.tumblr.com)
 * @license    http://www.gnu.org/copyleft/gpl.html     GNU General Public License, Version 3
 */

class ControllerFeedHotLine extends Controller {

    private $error = array();

    public function index() {

        $this->load->language('feed/hotline');

        $this->document->setTitle($this->language->get('heading_title'));

        $this->load->model('setting/setting');
        $this->load->model('catalog/category');

        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
            $this->model_setting_setting->editSetting('hotline', $this->request->post);

            $this->session->data['success'] = $this->language->get('text_success');

            $this->response->redirect($this->url->link('extension/feed', 'token=' . $this->session->data['token'], 'SSL'));
        }

        $data['heading_title'] = $this->language->get('heading_title');
        $data['edit_heading_title'] = $this->language->get('edit_heading_title');

        $data['text_enabled'] = $this->language->get('text_enabled');
        $data['text_disabled'] = $this->language->get('text_disabled');
        $data['note_category'] = $this->language->get('note_category');

        $data['entry_status'] = $this->language->get('entry_status');
        $data['entry_data_feed'] = $this->language->get('entry_data_feed');
        $data['entry_hotline_firm_id'] = $this->language->get('entry_hotline_firm_id');
        $data['entry_hotline_guarantee'] = $this->language->get('entry_hotline_guarantee');
        $data['entry_hotline_category'] = $this->language->get('entry_hotline_category');

        $data['button_save'] = $this->language->get('button_save');
        $data['button_cancel'] = $this->language->get('button_cancel');

        $data['tab_general'] = $this->language->get('tab_general');

        $data['categories'] = array();
        $categories = $this->model_catalog_category->getCategories(array(
            'sort' => 'name'
        ));

        if (isset($this->request->post['hotline_categories'])) {
            $data['hotline_categories'] = $this->request->post['hotline_categories'];
        } else {
            $data['hotline_categories'] = $this->config->get('hotline_categories');
        }

        foreach ($categories as $category) {
            $data['categories'][] = array(
                'name' => $category['name'],
                'category_id' => $category['category_id'],
                'selected' => $data['hotline_categories'] && in_array($category['category_id'], $data['hotline_categories'])
            );
        }

        if (isset($this->error['warning'])) {
            $data['error_warning'] = $this->error['warning'];
        } else {
            $data['error_warning'] = '';
        }

        $data['breadcrumbs'] = array();

        $data['breadcrumbs'][] = array(
            'text'      => $this->language->get('text_home'),
            'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
            'separator' => false
        );

        $data['breadcrumbs'][] = array(
            'text'      => $this->language->get('text_feed'),
            'href'      => $this->url->link('extension/feed', 'token=' . $this->session->data['token'], 'SSL')
        );

        $data['breadcrumbs'][] = array(
            'text'      => $this->language->get('heading_title'),
            'href'      => $this->url->link('feed/hotline', 'token=' . $this->session->data['token'], 'SSL')
        );

        $data['action'] = $this->url->link('feed/hotline', 'token=' . $this->session->data['token'], 'SSL');

        $data['cancel'] = $this->url->link('extension/feed', 'token=' . $this->session->data['token'], 'SSL');

        if (isset($this->request->post['hotline_status'])) {
            $data['hotline_status'] = $this->request->post['hotline_status'];
        } else {
            $data['hotline_status'] = $this->config->get('hotline_status');
        }

        if (isset($this->request->post['hotline_firm_id'])) {
            $data['hotline_firm_id'] = $this->request->post['hotline_firm_id'];
        } else {
            $data['hotline_firm_id'] = $this->config->get('hotline_firm_id');
        }

        if (isset($this->request->post['hotline_guarantee'])) {
            $data['hotline_guarantee'] = $this->request->post['hotline_guarantee'];
        } else {
            $data['hotline_guarantee'] = $this->config->get('hotline_guarantee');
        }

        $data['data_feed'] = HTTP_CATALOG . 'index.php?route=feed/hotline';

        $data['header'] = $this->load->controller('common/header');
        $data['column_left'] = $this->load->controller('common/column_left');
        $data['footer'] = $this->load->controller('common/footer');

        $this->response->setOutput($this->load->view('feed/hotline.tpl', $data));
    }

    private function validate() {
        if (!$this->user->hasPermission('modify', 'feed/hotline')) {
            $this->error['warning'] = $this->language->get('error_permission');
        }

        if (!$this->error) {
            return true;
        } else {
            return false;
        }
    }
}
