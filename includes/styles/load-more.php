
<?php if ($current_page < $total_pages) : ?>
    <div class="ai-tools-load-more-btn" style="text-align:center;margin-top:50px;">
        <button class="ai-tools-load-more" data-page="<?php echo esc_attr($current_page + 1); ?>" data-style="<?php echo $style; ?>" data-showcat="<?php echo $showcat; ?>" data-pricing="<?php echo $pricing; ?>">Load More</button>
    </div>
<?php endif; ?>
