<?php

global $wdfa_faq_data,$post;

if ( count( $wdfa_faq_data['questions'] ) == 0 ) {
    _e( 'No Faq Found', 'webdevelope-accordion-faq' );
    return ;
}
?>
<!-- List Template -->
<div class="webdevelope_faq webdevelope_faq_list wdfa-list<?php if ( is_rtl() ) { echo " is_rtl"; } else { echo " is_ltr"; } ?>" id="wdfa-<?php echo $faq_instance; ?>">
<?php
    if ( $args['use_search'] == "1" ) {
?>
    <div class="wdfa-search">
        <input type="search" name="wdfa-search" placeholder="<?php _e( "Search...", 'webdevelope-accordion-faq' ); ?>" />
    </div>
<?php
    }
?>
    <a id="wdfa-top"></a>
    <?php if ( isset( $wdfa_faq_data['terms'] ) ) { ?>
        <ul class="wdfa-toc">
            <?php
            $i=1;
            foreach( $wdfa_faq_data['terms'] as $terms ) {
                
                if ( count( $wdfa_faq_data['questions'][$terms->term_id] ) > 0 ) {
                    ?>
                    <li class="wdfa-cat">
                        <h2 class="wdfa-faq wdfa-list-cat"><a href="#<?php echo $terms->slug . $i++ ; ?>"><?php echo $terms->name; ?></a></h2>
                        <ul>
                            <?php
                            foreach( $wdfa_faq_data['questions'][$terms->term_id] as $post ) {
                                setup_postdata($post);
                               ?>
                                <li><h3 id="faq-<?php the_ID(); ?>" class="wdfa-list-q"><a href="#question-<?php the_ID(); ?>"><?php the_title()?></a></h3></li>
                               <?php
                            }
                            ?>
                        </ul>
                    </li>
                    <?php
                }
            }
            ?>
        </ul>
        <div class="wdfa-list-faqs">
            <?php
            $i=1;
            foreach( $wdfa_faq_data['terms'] as $terms ) {
                if( count($wdfa_faq_data['questions'][$terms->term_id]) > 0 ) {
                    ?>
                    <div class="wdfa-cat">
                        <h2 id="<?php echo $terms->slug . $i++ ; ?>" class="wdfa-list-cat"><?php echo $terms->name; ?></h2>
                        <?php
                        foreach( $wdfa_faq_data['questions'][$terms->term_id] as $post ) {
                            setup_postdata($post);
                            ?>
                            <article id="question-<?php the_ID(); ?>" class="wdfa wdfa-faq type-webdevelope_faq status-publish clearfix">
                                <h3 id="wdfa-q-<?php the_ID(); ?>" class="wdfa-list-q"><a name="<?php the_ID(); ?>"></a><?php the_title(); ?></h3>
                                <div class="wdfa-a">
                                    <?php the_content(); ?>
                                    <a class="wdfa-back-top" href="#wdfa-top"><?php _e( 'Back To Top', 'webdevelope-accordion-faq' ); ?></a>
                                </div>
                            </article>
                            <?php
                        }
                        ?>
                    </div>
                    <?php
                } 
            }
            ?>
        </div>

    <?php } else { ?>

        <ul class="wdfa-toc">
        <?php
        foreach ( $wdfa_faq_data['questions'] as $post ) {
            setup_postdata($post);
           ?>
            <li><h3 id="faq-<?php the_ID(); ?>" class="wdfa-list-q"><a href="#question-<?php the_ID(); ?>"><?php the_title()?></a></h3></li>
           <?php
        }
        ?>
        </ul>
        <?php
        foreach ( $wdfa_faq_data['questions'] as $post ) {
            setup_postdata($post);
            ?>
            <article id="question-<?php the_ID(); ?>" class="wdfa wdfa-faq type-webdevelope_faq status-publish clearfix">
                <h3 class="wdfa-list-q"><a name="<?php the_ID(); ?>"></a><?php the_title(); ?></h3>
                <div class="wdfa-a">
                    <?php the_content(); ?>
                    <a class="wdfa-back-top" href="#wdfa-top"><?php _e( 'Back To Top', 'webdevelope-accordion-faq' ); ?></a>
                </div>
            </article>
            
        <?php } ?>
    <?php } ?>
</div>