<?php
/**
 * Single Product Image
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/product-image.php.
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
 * @version     2.6.3
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

global $post, $product, $woocommerce;

$attachment_ids = $product->get_gallery_attachment_ids();

$images = array();
if ( has_post_thumbnail() )
{
	$props  = wc_get_product_attachment_props( get_post_thumbnail_id(), $post );
	$images[] = get_the_post_thumbnail( $post->ID, 'large', array(
				'title'	 => $props['title'],
				'alt'    => $props['alt']
			) );
}
foreach ($attachment_ids as $image_id):
	$props = array();
	$props = wc_get_product_attachment_props( $image_id, $post );
	$images[] = wp_get_attachment_image( $image_id, 'large', 0, $props );
endforeach;

?>
<?php if (count($images) > 0): ?>
	<div class="swiper-container product-gallery-main">
		<div class="swiper-wrapper">
			<?php foreach ($images as $image): ?>
				<div class="swiper-slide">
					<div class="image-wrapper em-fit-image">
						<?php echo $image;?>
					</div>
				</div>
			<?php endforeach; ?>
		</div>
		<!-- Add Arrows -->
		<div class="swiper-button-next swiper-button-white"></div>
        <div class="swiper-button-prev swiper-button-white"></div>
	</div>
	<div class="thumb-wrapper">
		<div class="swiper-container product-gallery-thumbs">
			<div class="swiper-wrapper">
				<?php foreach ($images as $image): ?>
					<div class="swiper-slide">
						<div class="image-wrapper">
							<?php echo $image;?>
						</div>
					</div>
				<?php endforeach; ?>
			</div>
		</div>
	</div>
<?php else: ?>
	<?php echo apply_filters( 'woocommerce_single_product_image_html', sprintf( '<div class="image-wrapper em-fit-image"><img src="%s" alt="%s" /></div>', wc_placeholder_img_src(), __( 'Placeholder', 'woocommerce' ) ), $post->ID ); ?>
<?php endif; ?>


