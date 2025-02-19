<?php

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

/**
 * Department Information Template
 * 
 * @var array $department_information
 */

if (empty($department_information))
    return;
?>

<div class="department-information">
    <div class="information-wrapper grid" style="display:grid;">
        <?php foreach ($department_information as $info):
            $title = $info['title'];
            $content = $info['content'];
            $link = $info['link'];
            $icon = $info['icon'];
            ?>
            <div class="department-item" style="display:flex;flex-direction:column;justify-content:space-between;">
                <h4 class="department-item-title" style="flex:1;"><?php echo $title ?></h4>
                <p class='department-item-description' style='flex:1;'><?php echo $content ?></p>
                <div class="department-item-link-wrapper" style="display:flex;flex:1;">
                    <?php if (!empty($link['value'])) {
                        echo "<a href='{$link['url']}' target='{$link['target']}' class='department-item-link'>{$link['title']}</a>";
                    } ?>
                </div>
                <div class="department-item-image-wrapper" style="display:flex;flex:1;">
                    <?php
                    if ($icon['type'] == 'media_library') {
                        $media_id = $icon['value']['id'];
                        echo wp_get_attachment_image($media_id, 'large', true);
                    }
                    if ($icon['type'] == 'dashicons') {
                        $dashicon_val = $icon['value'];
                        echo "<span class='dashicons $dashicon_val'></span>";
                    }
                    ?>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>