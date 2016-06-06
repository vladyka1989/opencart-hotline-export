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

    public function index() {

        $this->load->model('catalog/category');
        $this->load->model('catalog/product');
        $this->load->model('catalog/manufacturer');
        $this->load->model('feed/hotline');
        $this->load->model('tool/image');

        if ($this->config->get('hotline_status') && in_array($this->currency->getCode(), array('UAH'))) {

            $output  = '<?xml version="1.0" encoding="UTF-8" ?>';
            $output .= '<price>';
            $output .= '<date>' . date('Y-m-d H:i', time()) . '</date>';
            $output .= '<firmName>' . $this->config->get('config_name') . '</firmName>';
            $output .= '<firmId>' . $this->config->get('config_hotline_firm_id') . '</firmId>';

            // Currency rate
            if ('USD' == $this->currency->getCode()) {
                $output .= '<rate>' . number_format(1/$this->currency->getValue(), 2) . '</rate>';
            }

            // Categories
            $categories = $this->model_feed_hotline->getCategories();

            if ($categories) {
                $output .= '<categories>';
                foreach ($categories as $category) {
                    $output .= '<category>';
                    $output .= '<id>' . $category['category_id'] . '</id>';
                    if ($category['parent_id']) {
                        $output .= '<parentId>' . $category['parent_id'] . '</parentId>';
                    }
                    $output .= '<name>' . $category['name'] . '</name>';
                    $output .= '</category>';
                }
                $output .= '</categories>';
            }

            // Products
            $products = $this->model_catalog_product->getProducts(array('start' => 0, 'limit' => 1000000));

            if ($products) {

                $output .= '<items>';
                foreach ($products as $product) {
                    if ( $this->config->get('hotline_add_outofstock') == 0 ) {
                        if ($product['quantity'] < 1) continue;
                    }

                    $output .= '<item>';
                    $output .= '<id>' . $product['product_id'] . '</id>';


                    // Get Product Category
                    $category_id = false;
                    $product_categories = $this->model_catalog_product->getCategories($product['product_id']);

                    foreach ($product_categories as $product_category) {
                        $category_id = $product_category['category_id'];

                        // SEO PRO Main Category Support
                        if (isset($product_category['main_category_id']) && $product_category['main_category_id'] == 1) {
                            break;
                        }
                    }

                    if ($category_id) {
                        $output .= '<categoryId>' . $category_id . '</categoryId>';
                    }


                    $output .= '<code>' . $product['model'] . '</code>';

                    if ($product['manufacturer']) {
                        $output .= '<vendor>' . $product['manufacturer'] . '</vendor>';
                    }

                    $output .= '<name>' . $product['name'] . '</name>';

                    if ($product['description']) {
                        $stripped_tags = strip_tags(html_entity_decode($product['description']));
                        $output .= '<description>' . str_replace('&','',html_entity_decode($stripped_tags)) . '</description>';
                    }

                    $output .= '<url>' . $this->url->link('product/product', 'product_id=' . (int) $product['product_id']) . '</url>';

                    if ($product['image']) {
                        $output .= '<image>' . htmlspecialchars( $this->model_tool_image->resize($product['image'], $this->config->get('config_image_popup_width'), $this->config->get('config_image_popup_height')) ) . '</image>';
                    }

                    // Prepare Price
                    if ('USD' == $this->currency->getCode()) {
                        $special = $this->currency->convert($product['special'], 'USD', 'UAH');
                        $price = $this->currency->convert($product['price'], 'USD', 'UAH');
                        $special_usd = false;
                        $price_usd = false;
                    } else {
                        $special = $product['special'];
                        $price = $product['price'];
                        if ($this->config->get('hotline_add_usd') == 1) {
                            $special_usd = $this->currency->convert($product['special'], 'UAH', 'USD');
                            $price_usd = $this->currency->convert($product['price'], 'UAH', 'USD');
                        } else {
                            $special_usd = false;
                            $price_usd = false;
                        }
                    }

                    if ($special && $special < $price) {
                        $output .= '<priceRUAH>' . number_format($special, 2, '.', '') . '</priceRUAH>';
                        $output .= '<oldprice>' . number_format($price, 2, '.', '') . '</oldprice>';
                        if ($special_usd) {
                            $output .= '<priceRUSD>' . number_format($special_usd, 2, '.', '') . '</priceRUSD>';
                        }
                    } else {
                        $output .= '<priceRUAH>' . number_format($price, 2, '.', '') . '</priceRUAH>';
                        if ($price_usd) {
                            $output .= '<priceRUSD>' .  number_format($price_usd, 2, '.', '') . '</priceRUSD>';
                        }
                    }

                    if ($product['quantity']) {
                        $output .= '<stock>В наличии</stock>';
                    } else {
                        $output .= '<stock>Под заказ</stock>';
                    }

                    if ($this->config->get('config_hotline_guarantee')) {
                        $output .= '<guarantee>' . $this->config->get('config_hotline_guarantee') . '</guarantee>';
                    }

                    if ($this->config->get('hotline_add_attributes') == 1) {
                        $attributes_group = $this->model_catalog_product->getProductAttributes($product['product_id']);
                        foreach ($attributes_group as $attributes) {
                            foreach ($attributes["attribute"] as $attribute) {
                                $output .= '<param name="' . $attribute['name'] . '">' . $attribute['text'] . '</param>';
                            }
                        }
                    }

                    $output .= '</item>';
                }
                $output .= '</items>';
            }

            $output .= '</price>';

            $this->response->addHeader('Content-Type: application/xml');
            $this->response->setOutput($output);
        }
    }
}
