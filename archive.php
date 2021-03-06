<?php 
/**
 * The template for displaying archive pages
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 * @since 1.0.0
 * @package Sleekr
 */

get_header(); ?>

<!-- Display the WordPress Header Image -->
<?php if ( has_header_image() ) {
    echo '<img src="'; header_image(); echo'" height="'; echo get_custom_header()->height; echo '" width="'; echo get_custom_header()->width; echo'" alt="" class="img-page-featured" /><hr>';
} ?>

<!-- Page Content -->
<div class="container">

    <!-- Page Heading/Breadcrumbs -->
    <h1 class="mt-4 mb-3">
        <?php if ( is_category() ) {
            esc_html_e( 'Category Archive ', 'sleekr' );
            single_cat_title();
        } else if ( is_author() ) { 
            $curauth = (isset($_GET['author_name'])) ? get_user_by('slug', $author_name) : get_userdata(intval($author));
            esc_html_e( 'Author Archive ', 'sleekr' );
            echo $curauth->display_name;
        } else if ( is_day() ) {
            esc_html_e( 'Daily Archive ', 'sleekr' );
            echo (' '. get_the_time('F') .' '. get_the_time('jS') .' ');
        } else if ( is_month() ) {
            esc_html_e( 'Monthly Archive ', 'sleekr' );
            echo get_the_time('F');
        } else if ( is_year() ) {
            esc_html_e( 'Yearly Archive ', 'sleekr' );
            echo get_the_time('Y');
        } else if ( is_tag() ) {
            esc_html_e( 'Tag Archive ', 'sleekr' );
            single_tag_title();
        }?> 
    </h1><!-- /Page Heading -->
    <?php sleekr_custom_breadcrumbs(); ?>
        <!-- Category/Author/Tag Description -->
        <div class="lead">  <?php if ( is_category() ) {
                                echo category_description();
                            } else if ( is_author() ) {
                                echo $curauth->description;
                            } else if ( is_tag() ) {
                                echo tag_description();
                            }?>
        </div><!-- /.lead -->

    <div class="row mx-0">
  	<div class="col-lg-8 card pt-3">
            <!-- Start the Loop -->
            <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
		<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                    <!-- Title -->
                    <h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
                    <!-- Date/Time -->
                    <p class="display-time"><i class="fa fa-clock-o"></i> <?php esc_html_e('Posted on ','sleekr'); echo '<a href="'; echo get_day_link(get_post_time('Y'), get_post_time('m'), get_post_time('j')); echo '" class="entry-date">'; the_time( get_option( 'date_format' ) ); ?></a></p>
                    <!-- Author Link if isn't an Author Archive Page -->
                    <?php if ( !is_author() ) { echo '<p class="display-author">'; esc_html_e('by ','sleekr'); the_author_posts_link(); echo'</p>'; } ?>
                    <!-- Post Thumbnail -->
                    <?php if ( has_post_thumbnail() ) : ?>
                        <a href="<?php the_permalink(); ?>"><?php the_post_thumbnail( 'sleekr-thumbnail-avatar', array( 'class' => 'img-hover' ) );?></a>
                        <hr>
                    <?php endif ?>
                    <!-- Post Excerpt -->
                    <?php the_excerpt() ?>
                    <!-- Read More button -->
                    <a class="btn btn-primary" href="<?php the_permalink(); ?>"><?php esc_html_e('Read More','sleekr')?> <i class="fa fa-angle-right"></i></a>
                    <hr>
        	</div><!-- /Post -->
            <?php endwhile; else: ?>
		<p><?php esc_html_e('Sorry, there are no posts.', 'sleekr'); ?></p>
            <?php endif; ?>
            <!-- Custom Pagination -->
            <?php sleekr_custom_pagination(); ?>
        </div><!-- /.col-lg-8 .card -->
	<!-- Sidebar -->
  	<div id="Sidebar" class="col-lg-4 card">
    		<?php get_sidebar(); ?>
  	</div><!-- /.col-lg-4 .card -->
    </div><!-- /.row .mx-0-->


<?php get_footer(); ?>
