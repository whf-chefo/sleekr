<?php
/**
 * The template for a theme specific home page.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 * @since 1.0.0
 * @package Sleekr
 */
get_header(); ?>

<!-- If Front Page Display the Custom Theme Header Image -->
<?php if ( is_front_page() ) : ?>
<!-- Page Header Image -->
    <div id="header-image">
        <?php $mods = get_theme_mods();
        if ( get_theme_mod( 'sleekr_header_image' ) || !isset( $mods[ 'sleekr_header_image' ] ) ) { echo '<img class="img-page-featured" src="'.get_theme_mod( 'sleekr_header_image', THEME_URI . '/sleekr-header.png' ).'">'; }  ?>
    </div>
<hr>
<!-- Page Content -->
<div class="container">
<?php else : ?>
    <!-- If there is a Featured Image - Display it -->
    <?php if ( has_post_thumbnail() ) {
        the_post_thumbnail( 'full-width', array( 'class' => 'img-page-featured' ) );
        echo '<hr>';
    //If no Featured Image - Display the WordPress Header Image
    } else if ( has_header_image() ) {
            echo '<img src="'; header_image(); echo'" height="'; echo get_custom_header()->height; echo '" width="'; echo get_custom_header()->width; echo'" alt="" class="img-page-featured" /><hr>';
        }  
    ?>
<!-- Page Content -->
<div class="container">
<!-- Page Heading/Breadcrumbs -->
    <h1 class="mt-4 mb-3"><?php the_title(); ?></h1>
    <?php sleekr_custom_breadcrumbs(); ?>
<?php endif; ?>

<div class="row mx-0">
  <div class="col-lg-8 card pt-3">
	<!-- Start the Loop -->
	<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
        <?php the_content(); ?>
	<!-- Page Comments -->
        <?php comments_template(); ?>

	<?php endwhile; else: ?>
		<p><?php esc_html_e('Sorry, this page does not exist.','sleekr'); ?></p>
	<?php endif; ?>

  </div><!-- /.col-md-8 -->
  <div id="Sidebar" class="col-lg-4 card">
    <?php get_sidebar(); ?>
  </div><!-- /.col-md-4 -->
</div><!-- /.row -->

<?php get_footer(); ?>
