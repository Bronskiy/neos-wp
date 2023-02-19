<?php
	/**
	 * Block Name: gallery-slider
	 * This is the template that displays the section block.
	 */
	$gallery = get_field('gallery');
?>

<?php /* ADMIN */if (is_admin()) { ?>
	<div style="display:flex; align-items:center;">
		<div style="width:32px;height:32px;">
			<svg viewBox="0 0 24 24"><path d="M15.41,16.58L10.83,12L15.41,7.41L14,6L8,12L14,18L15.41,16.58Z"/></svg>
		</div>
		<?php foreach ($gallery as $i => $photo) { ?>
			<?php if ($i < 4):?>
				<div class="my-img-wrp">
					<img src="<?php echo $photo['sizes']['w240'] ?>" alt="">
				</div>
			<?php endif ?>
		<?php } ?>
		<div style="width:32px;height:32px;">
		<svg viewBox="0 0 24 24"><path d="M8.59,16.58L13.17,12L8.59,7.41L10,6L16,12L10,18L8.59,16.58Z"/></svg>
		</div>
	</div>

	<style type="text/css">
		.my-img-wrp {
			align-items: center;
			position: relative;
			width: 120px;
			height: 90px;
			margin: 2px;
		}
		.my-img-wrp img {
			width: 100%;
			height:100%;
			object-fit: cover;
		}
	</style>




<?php /* CLIENT */ } else {
	add_action ( 'wp_footer', function() use ( $block ) {
		echo "
			<script>
				if (window._\$_.wp_gb_pswp === undefined) window._\$_.wp_gb_pswp = [];
				window._\$_.wp_gb_pswp.push('{$block['id']}');
			</script>\n";
	});
?>
	<div class="photo-gallery-slider__slider-wrp">
		<div class="photo-gallery-slider" data-wp-gb-pswp-id="<?php echo $block['id'] ?>">
			<div class="swiper-wrapper">
				<?php /* Slides */ ?>
				<?php foreach ($gallery as $index => $photo) { ?>
					<?php /* Slide */ ?>
					<div class="swiper-slide">
						<div class="photo-gallery-slider__slide" data-my-slide-index="<?php echo $index ?>">
							<div class="photo-gallery-slider__slide-img-wrp">
								<img
									class="u-img-cover lazy"
									data-common-pswp-item-<?php echo $block['id'] ?> ="<?php echo htmlspecialchars( json_encode([
										'src' => $photo['sizes']['large'],
										'w' => $photo['sizes']['large-width'],
										'h' => $photo['sizes']['large-height'],
										'msrc' => $photo['sizes']['placeholder'],
										'title' => $photo['caption']? $photo['caption'] : null,
									]) ) ?>"
									src="<?php echo $photo['sizes']['placeholder'] ?>"
									data-src="<?php echo $photo['sizes']['w240'] ?>"
									data-srcset="
										<?php echo $photo['sizes']['w240'] ?> 240w,
										<?php echo $photo['sizes']['medium'] ?> 300w,
										<?php echo $photo['sizes']['w400'] ?> 400w,
										<?php echo $photo['sizes']['w576'] ?> 576w,
									"
									data-sizes="150px"
									alt="<?php echo $photo['alt'] ?>"
								/>
							</div>
						</div>
					</div>
				<?php } ?>
			</div>
		</div>
		
		<?php /* prev */ ?>
		<div class="photo-gallery-slider__swiper-btn-prev pswp-prev-<?php echo $block['id'] ?>">
			<div class="my-ui-icon-btn bgr-color--transparent">
				<div class="my__mdc-ripple-dark my__mdc-ripple--is-child mdc-ripple-upgraded"></div>
				<span class="material-icons">chevron_left</span>
			</div>
		</div>
		
		<?php /* next */ ?>
		<div class="photo-gallery-slider__swiper-btn-next pswp-next-<?php echo $block['id'] ?>">
			<div class="my-ui-icon-btn bgr-color--transparent">
				<div class="my__mdc-ripple-dark my__mdc-ripple--is-child mdc-ripple-upgraded"></div>
				<span class="material-icons">chevron_right</span>
			</div>
		</div>
	</div>
<?php } ?>