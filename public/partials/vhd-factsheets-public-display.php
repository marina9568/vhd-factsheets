<?php

/**
 * Provide a public-facing view for the plugin
 *
 * This file is used to markup the public-facing aspects of the plugin.
 *
 * @link       https://github.com/marina9568/vhd-factsheets
 * @since      1.0.0
 *
 * @package    Vhd_Factsheets
 * @subpackage Vhd_Factsheets/public/partials
 */
?>
<div class="vhd-content">
    <div class="container-fluid">
        <div class="vhd-row">
            <ul class="nav nav-tabs" role="tablist">
                <?php
                $i = 0;
                
                if (! is_array($factsheets)) {
                    exit();
                }
                
                foreach ( $factsheets as $pet => $types ) : 
                    $is_active_tab = $i == 0 ? ' class="active"' : '';
                    $i++     
                    ?>

                    <li role="presentation"<?php echo $is_active_tab ?>><a href="#<?php echo $pet ?>" aria-controls="<?php echo $pet ?>" role="tab" data-toggle="tab"><?php echo $pet ?></a></li>

                <?php endforeach; ?>
            </ul>
            <div class="tab-content">

                <?php 
                    $j = 0;
                    foreach ( $factsheets as $pet => $types ) :
                        $is_active_cont = $j == 0 ? ' active' : '';
                        $j++     
                ?>

                <div role="tabpanel" class="tab-pane<?php echo $is_active_cont ?>" id="<?php echo $pet ?>">
                    <?php foreach ( $types as $type => $array ) : ?>
                        <div class="vhd-row">
                            <div class="vhd-col-md-12">
                                <h2><?php echo $type ?></h2>
                            </div>
                        </div>
                        <div class="vhd-row">
                            <?php

                            foreach ( $array as $item ) : 
                                $fact_item = reset($item);
                                $vhd_id = substr( md5( rand() ), 2, 6 );
                                ?>
                                <div class="vhd-col-xs-12 vhd-col-sm-6 vhd-col-md-4">
                                    <a href class="vhd-fact-item" data-toggle="VHDmodal" data-target="#<?php echo $vhd_id; ?>">
                                        <span class="vhd-dot-container"><span class="vhd-dot"></span></span>
                                        <?php echo $fact_item; ?>
                                    </a>
                                    
                                    <?php add_action( 'wp_footer', function() use ($vhd_id, $fact_item, $item) { ?>
                                    <!-- Modal -->
                                    <div class="VHDmodal VHDfade" id="<?php echo $vhd_id; ?>" tabindex="-1" role="dialog">
                                        <div class="VHDmodal-dialog VHDmodal-lg" role="document">
                                            <div class="VHDmodal-content">
                                                <div class="VHDmodal-header">
                                                    <button type="button" class="close" data-dismiss="VHDmodal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                    <h2 class="VHDmodal-title" id="vhd-modal"><?php echo $fact_item; ?></h2>
                                                </div>
                                                <div class="VHDmodal-body">

                                                    <div class="panel-group" id="vhd-accordion<?php echo $vhd_id; ?>" role="tablist" aria-multiselectable="true">

                                                        <?php $k = 0;
                                                        foreach ( $item as $key => $value ) : 

                                                            if ($k == 0) {
                                                                $k++;
                                                                continue;
                                                            }

                                                            $tab_id = substr( md5( rand() ), 2, 6 );
                                                            ?>

                                                            <div class="panel panel-default">
                                                                <div class="panel-heading" role="tab" id="heading<?php echo $tab_id; ?>">
                                                                    <h4 class="panel-title vhd-panel">
                                                                        <a class="collapsed" role="button" data-toggle="collapse" data-parent="#vhd-accordion<?php echo $vhd_id; ?>" href="#collapse<?php echo $tab_id; ?>" aria-expanded="true" aria-controls="collapse<?php echo $tab_id; ?>">
                                                                        <?php echo $key; ?>
                                                                        </a>
                                                                    </h4>
                                                                </div>
                                                                <div id="collapse<?php echo $tab_id; ?>" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading<?php echo $tab_id; ?>">
                                                                    <div class="panel-body">
                                                                        <?php echo $value; ?>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                        <?php endforeach; ?>

                                                    </div>

                                                </div>
                                                <div class="VHDmodal-footer">
                                                    <button type="button" class="btn vhd-btn" data-dismiss="VHDmodal">Close</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php }); ?>
                                    

                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php endforeach; ?>

                </div>

                <?php endforeach; ?>

            </div>

        </div>
    </div>
</div>
<script>
    (function( $ ) {
	'use strict';
        
        var isMeta = false;
        
        $('meta').each(function( index, element ) {

            if($( element ).context.name == 'robots') {
               $( element ).context.content = 'noindex,nofollow';
               isMeta = true;
            }
        });
        
        if (!isMeta) {
            console.log(isMeta);
            $('head').append('<meta name="robots" content="noindex,nofollow" />');
        }
        
    })( jQuery );
</script>