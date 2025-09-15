<?php
/**
 * Template for displaying search forms
 *
 * @package Central_Build_Pro
 * @since 1.0.0
 */

?>

<form role="search" method="get" class="search-form" action="<?php echo esc_url(home_url('/')); ?>">
    <label for="search-field" class="screen-reader-text">
        <?php esc_html_e('Search for:', 'central-build'); ?>
    </label>
    <div class="search-form-wrapper">
        <input 
            type="search" 
            id="search-field" 
            class="search-field" 
            placeholder="<?php esc_attr_e('Search...', 'central-build'); ?>" 
            value="<?php echo get_search_query(); ?>" 
            name="s" 
            required
        />
        <button type="submit" class="search-submit" aria-label="<?php esc_attr_e('Search', 'central-build'); ?>">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M21 21L16.514 16.506L21 21ZM19 10.5C19 15.194 15.194 19 10.5 19C5.806 19 2 15.194 2 10.5C2 5.806 5.806 2 10.5 2C15.194 2 19 5.806 19 10.5Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
            <span class="screen-reader-text"><?php esc_html_e('Search', 'central-build'); ?></span>
        </button>
    </div>
</form>
