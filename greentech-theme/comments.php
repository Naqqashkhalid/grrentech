<?php
/**
 * The template for displaying comments
 *
 * @package GreenTech
 */

if (post_password_required()) {
    return;
}
?>

<div id="comments" class="comments-area">
    <?php if (have_comments()) : ?>
        <h2 class="comments-title">
            <?php
            $comments_number = get_comments_number();
            if (1 === $comments_number) {
                printf(_x('One thought on &ldquo;%s&rdquo;', 'comments title', 'greentech'), get_the_title());
            } else {
                printf(
                    _nx(
                        '%1$s thought on &ldquo;%2$s&rdquo;',
                        '%1$s thoughts on &ldquo;%2$s&rdquo;',
                        $comments_number,
                        'comments title',
                        'greentech'
                    ),
                    number_format_i18n($comments_number),
                    get_the_title()
                );
            }
            ?>
        </h2>

        <ol class="comment-list">
            <?php
            wp_list_comments([
                'style' => 'ol',
                'short_ping' => true,
                'callback' => 'greentech_comment_callback'
            ]);
            ?>
        </ol>

        <?php
        the_comments_navigation();

        if (!comments_open()) : ?>
            <p class="no-comments"><?php _e('Comments are closed.', 'greentech'); ?></p>
        <?php endif;
    endif;

    comment_form([
        'title_reply' => __('Leave a Comment', 'greentech'),
        'title_reply_to' => __('Leave a Comment to %s', 'greentech'),
        'cancel_reply_link' => __('Cancel Reply', 'greentech'),
        'label_submit' => __('Post Comment', 'greentech'),
        'comment_field' => '<p class="comment-form-comment">
            <label for="comment">' . _x('Comment', 'noun', 'greentech') . '</label>
            <textarea id="comment" name="comment" cols="45" rows="8" maxlength="65525" required="required"></textarea>
        </p>',
        'fields' => [
            'author' => '<p class="comment-form-author">
                <label for="author">' . __('Name', 'greentech') . ' <span class="required">*</span></label>
                <input id="author" name="author" type="text" value="' . esc_attr($commenter['comment_author']) . '" size="30" maxlength="245" required="required" />
            </p>',
            'email' => '<p class="comment-form-email">
                <label for="email">' . __('Email', 'greentech') . ' <span class="required">*</span></label>
                <input id="email" name="email" type="email" value="' . esc_attr($commenter['comment_author_email']) . '" size="30" maxlength="100" aria-describedby="email-notes" required="required" />
            </p>',
            'url' => '<p class="comment-form-url">
                <label for="url">' . __('Website', 'greentech') . '</label>
                <input id="url" name="url" type="url" value="' . esc_attr($commenter['comment_author_url']) . '" size="30" maxlength="200" />
            </p>',
        ],
    ]);
    ?>
</div>

<?php
/**
 * Custom comment callback function
 */
function greentech_comment_callback($comment, $args, $depth) {
    $GLOBALS['comment'] = $comment;
    extract($args, EXTR_SKIP);

    if ('div' == $args['style']) {
        $tag = 'div';
        $add_below = 'comment';
    } else {
        $tag = 'li';
        $add_below = 'div-comment';
    }
    ?>
    <<?php echo $tag ?> <?php comment_class('comment service-card'); ?> id="comment-<?php comment_ID() ?>">
        <div class="comment-meta">
            <div class="comment-author vcard">
                <?php echo get_avatar($comment, 60); ?>
                <div class="comment-author-info">
                    <?php printf(__('<cite class="fn">%s</cite>'), get_comment_author_link()); ?>
                    <div class="comment-metadata">
                        <a href="<?php echo htmlspecialchars(get_comment_link($comment->comment_ID)); ?>">
                            <?php printf(__('%1$s at %2$s'), get_comment_date(), get_comment_time()); ?>
                        </a>
                        <?php edit_comment_link(__('(Edit)'), '  ', ''); ?>
                    </div>
                </div>
            </div>
        </div>
        
        <?php if ($comment->comment_approved == '0') : ?>
            <em class="comment-awaiting-moderation"><?php _e('Your comment is awaiting moderation.', 'greentech'); ?></em>
        <?php endif; ?>

        <div class="comment-content">
            <?php comment_text(); ?>
        </div>

        <div class="comment-reply">
            <?php comment_reply_link(array_merge($args, ['add_below' => $add_below, 'depth' => $depth, 'max_depth' => $args['max_depth']])); ?>
        </div>
    <?php
}