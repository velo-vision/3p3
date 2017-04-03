<div class="the-content">
  <?php the_content();?>

</div>
<?php $show_meta = get_post_meta(get_the_ID(),'_epf_show_meta',TRUE);?>

<?php if ($show_meta == "") {?>
  <?php $show_meta = "on";?>

<?php }?>
<?php if ($show_meta == 'on') {?>
  <div class="container">
    <div class="the-meta">
      <ul class="portfolio-meta">
        <?php if (ERAM_Kirki::get_option('eram_theme_options','epf_enable_client',TRUE )) {?>
          <?php $client = get_post_meta(get_the_ID(),'_epf_meta_client',TRUE);?>

          <?php if ($client != '') {?>
            <li>
              <div class="lable">
                <?php esc_html_e('Client', 'eram');?>

              </div>
              <div class="value">
                <?php echo esc_html($client);?>

              </div>
            </li>
          <?php }?>
        <?php }?>
        <?php if (ERAM_Kirki::get_option('eram_theme_options','epf_enable_url',TRUE )) {?>
          <?php $link_url = get_post_meta(get_the_ID(),'_epf_meta_link_url',TRUE);?>

          <?php $link_lable = get_post_meta(get_the_ID(),'_epf_meta_link_label',TRUE);?>

          <?php if ($link_url != '') {?>
            <?php if ($link_lable == '') {?>
              <?php $link_lable = $link_url;?>

            <?php }?>
            <li>
              <div class="lable">
                <?php esc_html_e('URL', 'eram');?>

              </div>
              <div class="value">
                <a href="<?php echo esc_url($link_url);?>" target="_blank">
                  <?php echo esc_html($link_lable);?>

                </a>
              </div>
            </li>
          <?php }?>
        <?php }?>
        <?php if (ERAM_Kirki::get_option('eram_theme_options','epf_enable_date',TRUE )) {?>
          <?php $date = get_post_meta(get_the_ID(),'_epf_meta_date',TRUE);?>

          <?php if ($date != '') {?>
            <li>
              <div class="lable">
                <?php esc_html_e('Date', 'eram');?>

              </div>
              <div class="value">
                <?php echo date( get_option( 'date_format' ), strtotime( esc_html($date) ));?>

              </div>
            </li>
          <?php }?>
        <?php }?>
        <?php $dynamic_portfolio_fields = ERAM_Kirki::get_option('eram_theme_options','epf_custom_fields',array());?>

        <?php foreach($dynamic_portfolio_fields as $field):?>

          <?php $field_value = get_post_meta(get_the_ID(), '_epf_meta_dynamic_'.sanitize_title_with_dashes($field['name']) ,TRUE);?>

          <?php if ($field_value != '') {?>
            <li>
              <div class="lable">
                <?php echo esc_html($field['name']);?>

              </div>
              <div class="value">
                <?php echo esc_html($field_value);?>

              </div>
            </li>
          <?php }?>
        <?php endforeach;?>

      </ul>
    </div>
  </div>
<?php }?>