<style>
    .ai-row {
        display: flex;
        flex-direction: row;
        flex-wrap: wrap;
        gap: 20px;
        justify-content: center;
    }

    /* media quaries */
    @media only screen and (max-width: 526px) {
        .ai-row {
            display: flex;
            flex-direction: column;
        }
    }

    .ai-card {
        width: 100%;
        max-width: 350px;
        margin: 0 3px;
        border-radius: 5px;
        box-shadow: 0 0 5px rgba(0, 0, 0, 0.3);
        overflow: hidden;
        background-color: white;
    }

    .ai-card-header {
        display: flex;
        flex-direction: row;
        align-items: center;
        padding: 10px;
        flex-wrap: nowrap;
        justify-content: flex-start;
        gap: 10px;
        height: 100px;
    }

    .ai-card-header-icon {
        width: 80px;
        height: auto;
        background: white;
        padding: 5px;
        border-radius: 2px;
        box-shadow: 5px 5px 5px whitesmoke;
    }

    .ai-card-header-icon img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .ai-card-header-title p,
    .ai-card-header-title h3 {
        margin: 0;
        padding: 0;
    }

    .ai-card-header-title h3 {
        overflow: hidden;
        text-overflow: ellipsis;
        display: -webkit-box;
        -webkit-line-clamp: 1;
        -webkit-box-orient: vertical;
        margin-bottom: 5px;
    }

    .ai-card-body img {
        width: 100%;
        height: 200px;
        object-fit: fill;
    }

    .ai-card-footer {
        padding: 10px;
    }

    .ai-card-footer a {
        text-decoration: none !important;
        text-transform: uppercase;
        font-weight: 700;
        color: darkblue;
    }

    .ai-card-footer p {
        margin: 5px 0;
        padding: 0 5px;
        overflow: hidden;
        text-overflow: ellipsis;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        color: black;
    }

    .ai-card-header-title p {
        display: inline;
        background-color: greenyellow;
        padding: 2px 5px;
        border-radius: 20px;
        font-size: 15px;
    }

    .ai-footer-element {
        display: flex;
        flex-direction: row;
        align-items: center;
        justify-content: space-between;
        padding: 5px;
    }

    .ai-categories {
        background: floralwhite;
        padding: 10px;
        height: 100%;
    }

    .ai-categories ul {
        list-style: none !important;
        display: flex;
        gap: 5px;
        padding-left: 5px;
        flex-direction: row;
        flex-wrap: wrap;
        margin: 0px;
    }

    .ai-categories ul li {
        background-color: whitesmoke;
        padding: 5px 10px;
        border-radius: 20px;
        font-size: 12px;
    }
    button.ai-tools-load-more {
        background: #0071ff;
        padding: 10px 20px;
        color: white;
        border-radius: 5px;
        cursor: pointer;
        border: none;
    }

</style>

<div class="ai-row" id="ai-tools">
    <?php foreach ($api_data['tools'] as $tool): ?>
        <div class="ai-card" data="tool">
            <div class="ai-card-header">
                <div class="ai-card-header-icon">
                    <img src="<?php echo esc_url($tool['icon']); ?>" alt="<?php echo esc_attr($tool['name']); ?>">
                </div>
                <div class="ai-card-header-title">
                    <h3>
                        <?php echo $tool['name']; ?>
                    </h3>
                    <p>
                        <?php echo (isset($tool['pricing'])) ? $tool['pricing'] : "Free" ?>
                    </p>
                </div>
            </div>
            <div class="ai-card-body">
                <img src="<?php echo esc_url($tool['screenshot']); ?>" alt="<?php echo esc_attr($tool['name']); ?>">
            </div>
            <div class="ai-card-footer">
                <p>
                    <?php echo $tool['description']; ?>
                </p>
                <div class="ai-footer-element">
                    <a
                        href="<?php echo esc_url(add_query_arg(array('utm_source' => 'zyble.io', 'utm_medium' => get_bloginfo('name'), 'utm_campaign' => 'zyble.io'), $tool['url'])); ?>" target="_blank" rel="nofollow">Visit site</a>
                </div>
            </div>

            <?php if ( strtolower($showcat) == 'yes' ): ?>
            <div class="ai-categories">
                <ul>
                    <?php foreach ($tool['categories'] as $cat): ?>
                        <li>
                            <?php echo $cat; ?>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
            <?php endif; ?>
        </div>
    <?php endforeach; ?>
</div>

<?php if ( $show_load_more == 'yes' ) : ?>
    <?php include(plugin_dir_path(__FILE__) . 'load-more.php'); ?>
<?php endif; ?>

<center style="margin-top:20px"><span style="color: grey; font-size:12px; font-style:italic;">Powered by <a href="https://zyble.io" target="_blank" style="color:gray;text-decoration:none;">Zyble.io</a></span></center>