<?php echo $header; ?>

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


?>

<div id="content">
  <div class="breadcrumb">
    <?php foreach ($breadcrumbs as $breadcrumb) { ?>
    <?php echo $breadcrumb['separator']; ?><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
    <?php } ?>
  </div>
  <?php if ($error_warning) { ?>
  <div class="warning"><?php echo $error_warning; ?></div>
  <?php } ?>
  <div class="box">
    <div class="heading">
      <h1><img src="view/image/feed.png" alt="" /> <?php echo $heading_title; ?></h1>
      <div class="buttons"><a onclick="$('#form').submit();" class="button"><?php echo $button_save; ?></a><a onclick="location = '<?php echo $cancel; ?>';" class="button"><?php echo $button_cancel; ?></a></div>
    </div>
    <div class="content">
      <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form">
        <table class="form">
          <tr>
            <td><?php echo $entry_status; ?></td>
            <td><select name="hotline_status">
                <option value="0" <?php if ($hotline_status == 0) echo ' selected'; ?> ><?php echo $text_disabled; ?></option>
                <option value="1" <?php if ($hotline_status == 1) echo ' selected'; ?> ><?php echo $text_enabled; ?></option>
              </select>
            </td>
          </tr>
          <tr>
            <td><?php echo $entry_hotline_firm_id; ?></td>
            <td><input type="text" name="config_hotline_firm_id" value="<?php echo $config_hotline_firm_id; ?>"></td>
          </tr>
          <tr>
            <td><?php echo $entry_hotline_guarantee; ?></td>
            <td><input type="text" name="config_hotline_guarantee" value="<?php echo $config_hotline_guarantee; ?>"></td>
          </tr>
          <tr>
            <td><?php echo $entry_data_feed; ?></td>
            <td><textarea cols="40" rows="5"><?php echo $data_feed; ?></textarea></td>
          </tr>
          <tr>
            <td><?php echo $entry_add_attributes; ?></td>
            <td><select name="hotline_add_attributes">
                <option value="0" <?php if ($hotline_add_attributes == 0) echo ' selected'; ?> ><?php echo $text_disabled; ?></option>
                <option value="1" <?php if ($hotline_add_attributes == 1) echo ' selected'; ?> ><?php echo $text_enabled; ?></option>
              </select>
            </td>
          </tr>
          <tr>
            <td><?php echo $entry_add_outofstock; ?></td>
            <td><select name="hotline_add_outofstock">
                <option value="0" <?php if ($hotline_add_outofstock == 0) echo ' selected'; ?> ><?php echo $text_disabled; ?></option>
                <option value="1" <?php if ($hotline_add_outofstock == 1) echo ' selected'; ?> ><?php echo $text_enabled; ?></option>
              </select>
            </td>
          </tr>
        </table>
      </form>
    </div>
  </div>
</div>
<?php echo $footer; ?>
