<?php
/**
 * The template for displaying comments
 *
 * This is the template that displays the area of the page that contains both the current comments
 * and the comment form.
 *
 * @package Central_Build_Pro
 * @since 1.0.0
 */

/*
 * If the current post is protected by a password and
 * the visitor has not yet entered the password we will
 * return early without loading the comments.
 */
if (post_password_required()) {
    return;
}
?>

<div id="comments" class="comments-area">

    <?php
    // You can start editing here -- including this comment!
    if (have_comments()) :
        ?>
        <h2 class="comments-title">
            <?php
            $comment_count = get_comments_number();
        if ('1' === $comment_count) {
            printf(
                /* translators: 1: title. */
                esc_html__('One thought on &ldquo;%1$s&rdquo;', 'central-build'),
                '<span>' . wp_kses_post(get_the_title()) . '</span>'
            );
        } else {
            printf(
                /* translators: 1: comment count number, 2: title. */
                esc_html(_nx('%1$s thought on &ldquo;%2$s&rdquo;', '%1$s thoughts on &ldquo;%2$s&rdquo;', $comment_count, 'comments title', 'central-build')),
                number_format_i18n($comment_count), // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
                '<span>' . wp_kses_post(get_the_title()) . '</span>'
            );
        }
?>
        </h2>

        <?php the_comments_navigation(); ?>

        <ol class="comment-list">
            <?php
wp_list_comments(array(
    'style'      => 'ol',
    'short_ping' => true,
    'callback'   => 'central_build_comment',
));
?>
        </ol>

        <?php
        the_comments_navigation();

// If comments are closed and there are comments, let's leave a little note, shall we?
if (!comments_open()) :
    ?>
            <p class="no-comments"><?php esc_html_e('Comments are closed.', 'central-build'); ?></p>
            <?php
endif;

endif; // Check for have_comments().

// Comment form
$commenter = wp_get_current_commenter();
$req = get_option('require_name_email');
$aria_req = ($req ? " aria-required='true'" : '');

$comment_form_args = array(
    'title_reply'          => esc_html__('Leave a Reply', 'central-build'),
    'title_reply_to'       => esc_html__('Leave a Reply to %s', 'central-build'),
    'title_reply_before'   => '<h3 id="reply-title" class="comment-reply-title">',
    'title_reply_after'    => '</h3>',
    'cancel_reply_before'  => ' <small>',
    'cancel_reply_after'   => '</small>',
    'cancel_reply_link'    => esc_html__('Cancel reply', 'central-build'),
    'label_submit'         => esc_html__('Post Comment', 'central-build'),
    'submit_button'        => '<input name="%1$s" type="submit" id="%2$s" class="%3$s btn btn-primary" value="%4$s" />',
    'submit_field'         => '<p class="form-submit">%1$s %2$s</p>',
    'format'               => 'xhtml',
    'comment_field'        => '<p class="comment-form-comment"><label for="comment">' . esc_html__('Comment', 'central-build') . ' <span class="required">*</span></label><textarea id="comment" name="comment" cols="45" rows="8" maxlength="65525" required="required"></textarea></p>',
    'must_log_in'          => '<p class="must-log-in">' . sprintf(
        /* translators: %s: login URL */
        __('You must be <a href="%s">logged in</a> to post a comment.', 'central-build'),
        wp_login_url(apply_filters('the_permalink', get_permalink()))
    ) . '</p>',
    'logged_in_as'         => '<p class="logged-in-as">' . sprintf(
        /* translators: 1: edit user link, 2: accessibility text, 3: user name, 4: logout URL */
        __('<a href="%1$s" aria-label="%2$s">Logged in as %3$s</a>. <a href="%4$s">Log out?</a>', 'central-build'),
        get_edit_user_link(),
        /* translators: %s: user name */
        esc_attr(sprintf(__('Logged in as %s. Edit your profile.', 'central-build'), $user_identity)),
        $user_identity,
        wp_logout_url(apply_filters('the_permalink', get_permalink()))
    ) . '</p>',
    'comment_notes_before' => '<p class="comment-notes"><span id="email-notes">' . esc_html__('Your email address will not be published.', 'central-build') . '</span> ' . ($req ? '<span class="required-field-message">' . esc_html__('Required fields are marked *', 'central-build') . '</span>' : '') . '</p>',
    'comment_notes_after'  => '',
    'id_form'              => 'commentform',
    'id_submit'            => 'submit',
    'class_form'           => 'comment-form',
    'class_submit'         => 'submit',
    'name_submit'          => 'submit',
    'fields'               => array(
        'author' => '<p class="comment-form-author">' .
                    '<label for="author">' . esc_html__('Name', 'central-build') . ($req ? ' <span class="required">*</span>' : '') . '</label> ' .
                    '<input id="author" name="author" type="text" value="' . esc_attr($commenter['comment_author']) . '" size="30" maxlength="245"' . $aria_req . ' /></p>',
        'email'  => '<p class="comment-form-email">' .
                    '<label for="email">' . esc_html__('Email', 'central-build') . ($req ? ' <span class="required">*</span>' : '') . '</label> ' .
                    '<input id="email" name="email" type="email" value="' . esc_attr($commenter['comment_author_email']) . '" size="30" maxlength="100" aria-describedby="email-notes"' . $aria_req . ' /></p>',
        'url'    => '<p class="comment-form-url">' .
                    '<label for="url">' . esc_html__('Website', 'central-build') . '</label> ' .
                    '<input id="url" name="url" type="text" value="' . esc_attr($commenter['comment_author_url']) . '" size="30" maxlength="200" /></p>',
    ),
);

comment_form($comment_form_args);
?>

</div><!-- #comments -->

<?php
/**
 * Custom comment callback function
 */
function central_build_comment($comment, $args, $depth)
{
    if ('div' === $args['style']) {
        $tag       = 'div';
        $add_below = 'comment';
    } else {
        $tag       = 'li';
        $add_below = 'div-comment';
    }
    ?>
    <<?php echo $tag; ?> <?php comment_class(empty($args['has_children']) ? '' : 'parent'); ?> id="comment-<?php comment_ID(); ?>">
    <?php if ('div' !== $args['style']) : ?>
        <div id="div-comment-<?php comment_ID(); ?>" class="comment-body">
    <?php endif; ?>
    
    <div class="comment-author vcard">
        <?php if ($args['avatar_size'] != 0) {
            echo get_avatar($comment, $args['avatar_size']);
        } ?>
        <?php
        /* translators: %s: comment author link */
        printf(__('<cite class="fn">%s</cite> <span class="says">says:</span>', 'central-build'), get_comment_author_link());
    ?>
    </div>
    
    <?php if ($comment->comment_approved == '0') : ?>
        <em class="comment-awaiting-moderation"><?php esc_html_e('Your comment is awaiting moderation.', 'central-build'); ?></em>
        <br />
    <?php endif; ?>

    <div class="comment-meta commentmetadata">
        <a href="<?php echo htmlspecialchars(get_comment_link($comment->comment_ID)); ?>">
            <?php
        /* translators: 1: comment date, 2: comment time */
        printf(__('%1$s at %2$s', 'central-build'), get_comment_date(), get_comment_time());
    ?>
        </a>
        <?php edit_comment_link(__('(Edit)', 'central-build'), '&nbsp;&nbsp;', ''); ?>
    </div>

    <div class="comment-content">
        <?php comment_text(); ?>
    </div>

    <div class="reply">
        <?php
        comment_reply_link(array_merge($args, array(
    'add_below' => $add_below,
    'depth'     => $depth,
    'max_depth' => $args['max_depth']
        )));
    ?>
    </div>
    
    <?php if ('div' !== $args['style']) : ?>
        </div>
    <?php endif; ?>
    <?php
}
