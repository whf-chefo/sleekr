<?php
/**
 * Sleekr Lite Custom Comment Functions
 *
 * @since 1.0.0
 * @package Sleekr
 */

//Threaded comments after depth 2 function
function sleekr_comment_parent_link( $args = array() ) {

    echo sleekr_get_comment_parent_link( $args );
}

//Constructing the link for threaded comments after depth 2 
function sleekr_get_comment_parent_link( $args = array() ) {

    $link = '';

    $defaults = array(
        'text'   => '%s', // Defaults to comment author.
        'depth'  => 2,    // At what level should the link show.
        'before' => '',   // String to output before link.
        'after'  => ''    // String to output after link.
    );

    $args = wp_parse_args( $args, $defaults );

    if ( $args['depth'] <= $GLOBALS['comment_depth'] ) {

        $parent = get_comment()->comment_parent;

        if ( 0 < $parent ) {

            $url  = esc_url( get_comment_link( $parent ) );
            $text = sprintf( $args['text'], get_comment_author( $parent ) );

            $link = sprintf( '%s<a class="comment-parent-link" href="%s"><span class="fa fa-reply"></span> %s</a>%s', $args['before'], $url, $text, $args['after'] );
        }
    }

    return $link;
}

    //WP List Comment Callback Function
function sleekr_comments($comment, $args, $depth) {
    if ( 'div' === $args['style'] ) {
        $tag       = 'div';
        $add_below = 'comment';
    } else {
        $tag       = 'li';
        $add_below = 'div-comment';
    }
    //Allowed HTML for escaping
    $allowed_html = array(
            'strong' => array(),
            'em'     => array(),
            'b'      => array(),
            'i'      => array(),
            's'      => array(),
            'strike' => array(),
            'cite'   => array(),
            'code'   => array(),
            'a'     => array(
                'href' => array(),
                'title'=> array()
            ),
	    'img'      	=> array(
                'src'  	=> array(),
                'title'	=> array(),
		'alt'	=> array(),
		'width'	=> array(),
		'height'=> array()
            ),
            'abbr' => array(
		        'title' => array()
	        ),
            'acronym' => array(
                'title' => array()
            ),
            'blockquote' => array(
                'cite' => array()
            ),
            'del' => array(
                'datetime' => array()
            ),
            'q' => array(
                'cite' => array()
            )
    );
    //Switch in cases of pingback or trackback
    switch( $comment->comment_type ) :
        case 'pingback' :
        case 'trackback' : ?>
            <div <?php comment_class('list-group'); ?> id="comment<?php comment_ID(); ?>">
            <div class="list-group-item"><?php comment_author_link(); ?></div>
        <?php break;
        default : ?>
    <<?php echo $tag ?> <?php comment_class( empty( $args['has_children'] ) ? 'card' : 'parent card' ) ?> id="comment-<?php comment_ID() ?>">
    <?php sleekr_comment_parent_link(
	    array(
		'depth'  => 3,
		'text'   => esc_html__( 'In reply to %s', 'sleekr' ),
		'before' => '<div class="comment-parent">',
		'after'  => '</div>'
	    )
	    ); ?>
    <div class="card-body">
        <?php if ( $args['avatar_size'] != 0 ) {echo '<div class="float-left mr-3">'.get_avatar( $comment, $args['avatar_size']).'</div>';} ?>
        <?php echo '<h4>'.get_comment_author_link().' <small><a href="'; echo htmlspecialchars( get_comment_link( $comment->comment_ID ) ); echo'">';
        /* translators: 1: date, 2: time */
        printf( esc_html_x('%1$s at %2$s','date and time','sleekr'), get_comment_date(),  get_comment_time() ); ?></a><?php edit_comment_link( esc_html__( '(Edit)','sleekr' ), '  ', '' );
        ?></small></h4>
	<!-- Comment is Awaiting Moderation -->
        <?php if ( $comment->comment_approved == '0' ) : ?>
             <em class="comment-awaiting-moderation"><?php esc_html_e( 'Your comment is awaiting moderation.','sleekr' ); ?></em>
              <br />
        <?php endif; ?>
	<!-- Escaping HTML and allowing only certain tags -->
        <?php echo wp_kses( get_comment_text(), $allowed_html ) ?>
	<!-- Reply Link -->
        <div class="float-right">
            <?php comment_reply_link( array_merge( $args, array( 'add_below' => $add_below, 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>
        </div><!-- /.float-right -->
    </div><!-- .card-body -->
    <?php break; ?>
    <?php endswitch; ?>
    <?php
    }
    
?>
