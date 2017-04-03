<?php
/**
 * The Template for displaying product archives, including the main shop page which is a post type archive
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/archive-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see 	    https://docs.woocommerce.com/document/template-structure/
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

get_header( 'shop' ); ?>

	<div id="main-area" class="layout-padding">
        <?php # start: modified by Safa ?>
        <?php $header_type =  eram_woo_get_option('eram_shop_header','simple');?>
        <?php $show_page_header =  $header_type != 'none' ? true : false; ?>
        <?php $shop_continer_class = ''; ?>

        <?php if($header_type == 'with-image' && is_shop() && !is_search() ): ?>
            <?php $header_class=$header_parallax_mode=$content_parallax_mode=$cover_image=$inline_styles=$content_class="";?>
            <?php $has_parallax = Eram_Kirki::get_option('eram_theme_options','eram_has_parallax',true);?>
            <?php $header_hvh = "hvh-". intval(Eram_Kirki::get_option('eram_theme_options','eram_top_header_height',60) );?>
            <?php $cover_image_id = eram_woo_get_shop_featured_image_id(); ?>
            <?php $has_cover = $cover_image_id == '' ? false : true;?>
            <?php $cover_image = wp_get_attachment_url($cover_image_id); ?>
            <?php if ($has_cover): ?>
                <?php if ($has_parallax): ?>
                    <?php $header_class="parallax-layer has-cover ov-dark-alpha-50 ". $header_hvh;?>
                    <?php $content_class = "parallax-layer";?>
                    <?php $content_parallax_mode = "mode-header-content";?>
                <?php else: ?>
                    <?php $header_class="has-cover ov-dark-alpha-50 ". $header_hvh;?>
                    <?php $inline_styles="background-image:url(" . $cover_image . ");"?>
                <?php endif; ?>
            <?php endif; ?>

            <div class="page-head woocommerce-page-head <?php echo $header_class; ?>" data-img-src="<?php echo $cover_image; ?>" data-parallax-mode="<?php echo $header_parallax_mode; ?>" style="<?php echo $inline_styles;?>">
                <div class="tb-vcenter-wrapper">
                    <div class="title-wrapper vcenter <?php echo $content_class; ?>" data-parallax-mode="<?php echo $content_parallax_mode; ?>">
                        <h1 class="title"><?php woocommerce_page_title(); ?></h1>
                        <div class="description"><?php do_action( 'woocommerce_archive_description' ); ?></div>
                    </div>
                </div>
            </div>
        <?php else: ?>
            <?php $shop_continer_class = 'has-top-space'; ?>
        <?php endif; ?>

        <div class="container main-shop-container <?php echo $shop_continer_class;?>">
            <div class="woocommerce-header">
                <?php if ( apply_filters( 'woocommerce_show_page_title', true ) ) : ?>
                    <div class="title-holder">
                        <?php if ($header_type == 'simple' || !is_shop() || is_search() ): ?>
                            <h1 class="page-title"><?php woocommerce_page_title(); ?></h1>
                            <?php if ( !is_search() ): ?>    
                                <?php do_action( 'woocommerce_archive_description' ); ?>
                            <?php endif; ?>
                        <?php endif; ?>

                        <?php woocommerce_result_count(); ?>
                    </div>
                <?php endif; ?>

                <?php if( apply_filters( 'eram_wc_show_product_sorting', true ) ): ?>
                    <div class="woocommerce-ordering-container">
                        <?php woocommerce_catalog_ordering(); ?>
                    </div>
                <?php endif; ?>
            </div>

            <?php woocommerce_product_subcategories( array( 'before' => '<div class="woocommerce columns-3"><ul class="products">', 'after' => '</ul></div>' ) ); ?>

            <?php # end: modified by Safa ?>

            <?php if ( have_posts() ) : ?>

                <?php
                /**
                 * woocommerce_before_shop_loop hook
                 *
                 * @hooked woocommerce_result_count - 20
                 * @hooked woocommerce_catalog_ordering - 30
                 */
                do_action( 'woocommerce_before_shop_loop' );
                ?>

                <?php woocommerce_product_loop_start(); ?>

                <?php while ( have_posts() ) : the_post(); ?>

                    <?php wc_get_template_part( 'content', 'product' ); ?>

                <?php endwhile; // end of the loop. ?>

                <?php woocommerce_product_loop_end(); ?>

                <?php
                /**
                 * woocommerce_after_shop_loop hook
                 *
                 * @hooked woocommerce_pagination - 10
                 */
                do_action( 'woocommerce_after_shop_loop' );
                ?>

            <?php elseif ( ! woocommerce_product_subcategories( array( 'before' => woocommerce_product_loop_start( false ), 'after' => woocommerce_product_loop_end( false ) ) ) ) : ?>
            <?php #elseif ( ! defined( 'SHOP_HAS_CATEGORIES' ) ) : ?>

                <?php wc_get_template( 'loop/no-products-found.php' ); ?>

            <?php endif; ?>
        </div><!-- .container -->

        <?php eram_footer(); ?>
        
    </div><!-- #main-area -->


<?php get_footer( 'shop' ); ?>



	


