<style type="text/css">
    
    /* Primary Color */

    a:link,
    a:visited,
    .gp-leaflet-map-container .gp-map-markers-index ul a:link,
    .gp-leaflet-map-container .gp-map-markers-index ul a:visited    {color:<?php echo $primary_color; ?>}

    #projects-list li a:link,
    #projects-list li a:visited,
    .entry-summary .entry-more:link,
    .entry-summary .entry-more:visited,
    .site-navigation a:link, 
    .site-navigation a:visited,
    .widget-posts-in-list-more a:link,
    .widget-posts-in-list-more a:visited                            {background-color:<?php echo $primary_color; ?>}

    #site-navigation ul li                                          {border-bottom-color:<?php echo $primary_color; ?>}

    /* Secondary Color */

    a:hover,
    a:active,
    a:focus                                                         {color:<?php echo $secondary_color; ?>}

    #site-navigation ul a:hover,
    #site-navigation ul a:active,
    #site-navigation ul a:focus,
    #site-navigation ul .current-menu-item a,
    #site-navigation ul .current_page_item a,
    #projects-list li a:hover,
    #projects-list li a:active,
    #projects-list li a:focus,
    #projects-list li.current-project-page a,
    .entry-summary .entry-more:hover,
    .entry-summary .entry-more:active,
    .entry-summary .entry-more:focus,
    article.type-projects,
    .gp-leaflet-map-container .gp-map-markers-index ul,
    .site-navigation a:hover,
    .site-navigation a:active,
    .site-navigation a:focus,
    .widget-posts-in-list-more a:hover,
    .widget-posts-in-list-more a:active,
    .widget-posts-in-list-more a:focus                              {background-color:<?php echo $secondary_color; ?>}

    /* ---------------------
      550px <= Width
    --------------------- */

    @media screen and (min-width: 550px) {

        /* Primary Color */

        #site-navigation ul a                                       {border-top-color:<?php echo $primary_color; ?>}

        .gp-map-actions-toggles .gp-map-markers-index-toggle:hover,
        .gp-map-actions-toggles .gp-map-markers-index-toggle:active,
        .gp-map-actions-toggles .gp-map-markers-index-toggle:focus,
        .gp-map-actions-toggles .gp-map-markers-index-toggle.active,
        .gp-map-actions-toggles .gp-map-export-map-toggle:hover,
        .gp-map-actions-toggles .gp-map-export-map-toggle:active,
        .gp-map-actions-toggles .gp-map-export-map-toggle:focus,
        .gp-map-actions-toggles .gp-map-export-map-toggle.active    {background-color:<?php echo $primary_color; ?>}

        /* Secondary Color */

        #site-navigation ul .current-menu-item a,
        .gp-map-actions-toggles .gp-map-markers-index-toggle:link,
        .gp-map-actions-toggles .gp-map-markers-index-toggle:visited,
        .gp-map-actions-toggles .gp-map-export-map-toggle:link,
        .gp-map-actions-toggles .gp-map-export-map-toggle:visited   {background-color:<?php echo $secondary_color; ?>}

        .gp-map-actions-toggles a                                   {border-color:<?php echo $secondary_color; ?>}

    }

</style>