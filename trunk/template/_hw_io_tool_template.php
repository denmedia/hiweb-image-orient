<?php

    $attachments = get_posts(array('post_type' => 'attachment','posts_per_page' => -1));
    $images = array();
    foreach ($attachments as $attachment) {
        $image = _hw_io_getOrientFromImagePost($attachment, false);
        if ($image !== false && $image['meta']['image_meta']['orientation'] != 0 && $image['meta']['image_meta']['orientation'] != 1) {
            $images[] = array('id' => $attachment->ID, 'orientation' => $image);
        }
    }


?>
<div id="wpbody" role="main">

    <div id="wpbody-content" aria-label="Main content" tabindex="0">
        <div class="wrap">
            <h1>hiWeb Images ReOrientation</h1>

            <p>Images found: <b><?php echo count($images) ?></b></p>
            <?php if (count($images) == 0) : ?>
                <p>Since the images found on the orientation information, personal handle...</p>
            <?php else: ?>
                <div class="media-toolbar wp-filter">
                    <div class="progress-bar">
                        <div></div>
                    </div>
                </div>
                <p>
                    <button class="button button-primary" id="hw-io-reorient-tool-start">Start ReOrient Images</button>
                </p>
                <h2 class="hw_io_message_done">All images are orient. Total images: <b data-count="">0</b></h2>
                <script>hw_io_tool.init(<?php echo json_encode($images); ?>, '#hw-io-reorient-tool-start');</script>
            <?php endif; ?>

        </div>

        <div class="clear"></div>
    </div><!-- wpbody-content -->
    <div class="clear"></div>
</div>