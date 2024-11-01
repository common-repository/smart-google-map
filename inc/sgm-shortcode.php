<?php

function sgm_get_markers($category){
    $markers= array();
    $args = array(
        'post_type' => 'smart-google-map',
		'posts_per_page'=>-1,
        'tax_query' => array(
            array(
                'taxonomy' => 'marker-category',
                'field'    => 'slug',
                'terms'    => $category,
            ),
        ),
    );
    
    $the_query = new WP_Query( $args );

    if ( $the_query->have_posts() ) :
        while ( $the_query->have_posts() ) :
            $the_query->the_post();
            $post_id = get_the_id();
            $content = '<div class="sgm-iw-container">
                            <div class="sgm-iw-title">'.get_the_title().'</div>
                            <div class="sgm-iw-content">';
            if(has_post_thumbnail())
                $content .= '<img src="'.get_the_post_thumbnail_url(null, array(150,150)).'" alt="'.get_the_title().'" height="150" width="150">';

            $content .= wpautop(get_the_content()).'</div></div>';
            $markers[] = array(
                'title'=> get_the_title(), 
                'content' => $content, 
                'lat'=> get_post_meta($post_id, 'sgm-marker-lat', true), 
                'lng'=>get_post_meta($post_id, 'sgm-marker-lng', true)
            );
        endwhile; 
        wp_reset_postdata(); 
    endif;

    return $markers;
}


add_shortcode( 'smart-google-map', 'sgm_shortcode_handler' );

function sgm_shortcode_handler($atts) {
	ob_start();
	?>
	<style type="text/css">
        
        .sgm-map-wrapper .sgm-map{
            height: 500px !important;
            width: 100% !important;
		}

        .sgm-map-wrapper .sgm-links{
            display: flex;
            justify-content: center;
            flex-wrap: wrap;
        }

        .sgm-map-wrapper .sgm-links button.sgm-item{
            font-size: 18px !important;
            font-weight: normal;
            background-color: #00bcd4;
            border: 1px solid #009baf;
            margin-right: 10px;
            margin-bottom: 10px;
            padding: 8px 14px;
            color: #fff;
            cursor: pointer;
        }

        .sgm-map-wrapper .sgm-links button.sgm-item.active{
            background-color: #009baf;
        }

        .sgm-iw-container {
            margin-bottom: 10px !important;
        }

        .sgm-iw-title {
            font-size: 18px !important;
            font-weight: bold !important;
        }
        
        .sgm-iw-content{
            font-size: 12px !important;
            font-weight: normal !important;
            line-height: 20px !important;
        }

        .sgm-iw-content img{
            float: right !important;
            margin-bottom: 5px !important;
            margin-left: 5px !important;
        }

        @media only screen and (max-width: 767px) {
            .sgm-map-wrapper .sgm-links{
                flex-direction: column;
            }
        }

	</style>
    <div class="sgm-map-wrapper">
        <div id="sgm-map" class="sgm-map"></div>
        <?php
        $categories = get_terms('marker-category');
        if(!empty($categories)){
        ?>
            <div class="sgm-links">
                <?php
                foreach ($categories as $category) {
                    ?>
                    <button class="sgm-item" data-cat-slug="<?php echo $category->slug; ?>" ><?php echo $category->name; ?></button>
                    <?php
                }
                ?>
            </div>
        <?php
        }else{
                _e('No category found.','smart-google-map');
        }
        ?>
    </div>
    
    <?php
    $markers_arr = array();

    if(!empty($categories)){
        foreach ($categories as $category) {
            $markers_arr[$category->slug] = sgm_get_markers($category->slug);
        }
    }
    
?>
    <script type="text/javascript">
        (function($){
            var map, bounds;
            var data = <?php echo json_encode($markers_arr); ?>;
            var markers= [];

            function removeMarkers(){
                while(markers.length){
                    markers.pop().setMap(null);
                }
            }
            
            $(window).load(function(){
                var mapOptions = {
                    mapTypeId: 'roadmap',
                    scrollwheel: false
                };
              
                map = new google.maps.Map(document.getElementById("sgm-map"), mapOptions);
                map.setTilt(45);
                
                map.addListener('zoom_changed', function() {
                    if(map.getZoom()> 10){
                      map.setZoom(10);
                    }
                });
                $('button.sgm-item').eq(0).trigger('click');
            });
            
            $(document).on('click', 'button.sgm-item', function(event) {
                $('button.sgm-item').not(this).removeClass('active');
                $(this).addClass('active');
                var infoWindow = new google.maps.InfoWindow(), marker, i;
                var cat_slug = $(this).attr('data-cat-slug');
                bounds = new google.maps.LatLngBounds();
                removeMarkers();
                for(i=0; i<data[cat_slug].length; i++){
                    var position = new google.maps.LatLng(data[cat_slug][i].lat, data[cat_slug][i].lng);
                    bounds.extend(position);
                    marker = new google.maps.Marker({
                        position: position,
                        map: map,
                        animation: google.maps.Animation.DROP,
                        title: data[cat_slug][i].title
                    });

                    markers.push(marker);

                    google.maps.event.addListener(marker, 'click', (function(marker, i) {
                        return function() {
                            var content = data[cat_slug][i].content;
                            infoWindow.setContent(content);
                            infoWindow.open(map, marker);
                        }
                    })(marker, i));

                    map.fitBounds(bounds);
                    map.panToBounds(bounds); 
                }
               
            });
        })(jQuery);
    </script>
    <script async defer src="https://maps.googleapis.com/maps/api/js?key=<?php echo get_option('google_map_api_key'); ?>&sensor=false">
    </script>
	<?php
	return ob_get_clean();
}

?>