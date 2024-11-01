<?php

global $wdfa_faq_data,$post,$wdfa;

if ( count( $wdfa_faq_data['questions'] ) == 0 ) {
    _e('No Faq Found','webdevelope-accordion-faq');
    return ;
}

$icon_closed = $wdfa->get( 'icon_closed' );

if ( isset( $icon_closed ) && $icon_closed != '' ) {
    $icon   = '<span style="background-color:' . $args["icon_bg_color"] . '; border-radius: ' . $args["icon_bg_radius"] . 'px; ?>;"><i class="' . $icon_closed . '" style="color: ' . $args['icon_color'] . '"></i></span>';
    $class  = ' wdfa-icon';
} else {
    $icon   = '';
    $class  = '';
}

?>
<!-- Accordion Template -->
<div class="webdevelope_faq webdevelope_faq_accordion<?php if ( is_rtl() ) { echo " is_rtl"; } else { echo " is_ltr"; } ?>" id="wdfa-<?php echo $faq_instance; ?>">
<?php
    if ( $args['use_search'] == "1" ) {
?>
    <div class="wdfa-search">
        <input type="search" name="wdfa-search" placeholder="<?php _e( "Search...", 'webdevelope-accordion-faq' ); ?>" />
    </div>
<?php
    }
?>
    <?php
    if ( isset( $wdfa_faq_data['terms'] ) ) {
        $i = 1;
        foreach ( $wdfa_faq_data['terms'] as $terms ) {
            if ( count( $wdfa_faq_data['questions'][ $terms->term_id ] ) > 0 ) {
                ?>
                <div class="wdfa-cat wdfa-accordion-cat">
                    <h2>
                        <a name="<?php echo $i++ . $terms->slug; ?>"></a><?php echo $terms->name; ?>
                    </h2>
                    <?php
                    foreach( $wdfa_faq_data['questions'][ $terms->term_id ] as $post ) {
                        setup_postdata( $post );
                        ?>
                        <div class="wdfa-faq wdfa-accordion<?php echo $class; ?>">
                            <h3 class="wdfa-accordion-q"><?php echo $icon; ?><?php the_title(); ?></h3>
                            <div class="wdfa-accordion-a">
                                <?php the_content(); ?>
                            </div>
                        </div>
                    <?php
                } ?>
                </div>
        <?php } 
        }
        
    } else {
        foreach ( $wdfa_faq_data['questions'] as $post ) {
            setup_postdata($post);
        ?>
        <div class="wdfa-faq wdfa-accordion<?php echo $class; ?>">
            <h3 class="wdfa-accordion-q"><?php echo $icon; ?><?php the_title(); ?></h3>
            <div class="wdfa-accordion-a">
                <?php the_content(); ?>
            </div>
        </div>
        <?php
        }
    }?>
</div>
