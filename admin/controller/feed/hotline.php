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
 * @package    OCU Hotline Export
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

        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
            $this->model_setting_setting->editSetting('hotline', $this->request->post);

            $this->session->data['success'] = $this->language->get('text_success');

            $this->redirect($this->url->link('extension/feed', 'token=' . $this->session->data['token'], 'SSL'));
        }

        $this->data['heading_title'] = $this->language->get('heading_title');

        $this->data['text_enabled'] = $this->language->get('text_enabled');
        $this->data['text_disabled'] = $this->language->get('text_disabled');

        $this->data['entry_status'] = $this->language->get('entry_status');
        $this->data['entry_data_feed'] = $this->language->get('entry_data_feed');
        $this->data['entry_hotline_firm_id'] = $this->language->get('entry_hotline_firm_id');
        $this->data['entry_hotline_guarantee'] = $this->language->get('entry_hotline_guarantee');

        $this->data['button_save'] = $this->language->get('button_save');
        $this->data['button_cancel'] = $this->language->get('button_cancel');

        $this->data['tab_general'] = $this->language->get('tab_general');

        if (isset($this->error['warning'])) {
            $this->data['error_warning'] = $this->error['warning'];
        } else {
            $this->data['error_warning'] = '';
        }

        $this->data['breadcrumbs'] = array();

        $this->data['breadcrumbs'][] = array(
            'text'      => $this->language->get('text_home'),
            'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
            'separator' => false
        );

        $this->data['breadcrumbs'][] = array(
            'text'      => $this->language->get('text_feed'),
            'href'      => $this->url->link('extension/feed', 'token=' . $this->session->data['token'], 'SSL'),
            'separator' => ' :: '
        );

        $this->data['breadcrumbs'][] = array(
            'text'      => $this->language->get('heading_title'),
            'href'      => $this->url->link('feed/hotline', 'token=' . $this->session->data['token'], 'SSL'),
            'separator' => ' :: '
        );

        $this->data['action'] = $this->url->link('feed/hotline', 'token=' . $this->session->data['token'], 'SSL');

        $this->data['cancel'] = $this->url->link('extension/feed', 'token=' . $this->session->data['token'], 'SSL');

        if (isset($this->request->post['hotline_status'])) {
            $this->data['hotline_status'] = $this->request->post['hotline_status'];
        } else {
            $this->data['hotline_status'] = $this->config->get('hotline_status');
        }

        if (isset($this->request->post['config_hotline_firm_id'])) {
            $this->data['config_hotline_firm_id'] = $this->request->post['config_hotline_firm_id'];
        } else {
            $this->data['config_hotline_firm_id'] = $this->config->get('config_hotline_firm_id');
        }

        if (isset($this->request->post['config_hotline_guarantee'])) {
            $this->data['config_hotline_guarantee'] = $this->request->post['config_hotline_guarantee'];
        } else {
            $this->data['config_hotline_guarantee'] = $this->config->get('config_hotline_guarantee');
        }

        $this->data['data_feed'] = HTTP_CATALOG . 'index.php?route=feed/hotline';

        $this->template = 'feed/hotline.tpl';
        $this->children = array(
            'common/header',
            'common/footer'
        );

        $this->response->setOutput($this->render());
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
