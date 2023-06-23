<?php
        get_header();
        pageBanner(array(
            //'title' => 'Our Campuses',
            //'subtitle' => ()//,
            //'photo' => get_theme_file_uri('/images/ocean.jpg')
        ));
     
     
        while(have_posts()) {
            the_post(); 
            $map_location = get_field('map_location');
     
            ?>
            
     
            <div class="container container--narrow page-section">
                <div class="metabox metabox--position-up metabox--with-home-link">
                    <p>
                    <a class="metabox__blog-home-link" href="<?php echo get_post_type_archive_link('campus') ?> ">
                    <i class="fa fa-home" aria-hidden="true"></i>All Campuses</a> <span class="metabox__main"><?php the_title(); ?></span>
                    </p>
                </div>
     
                <div class="generic-content">
                    <?php the_content() ?>
                </div>

                <!-- HTMl MAP -->
                
                

                <?php print_r($map_location); ?><br>
                <?php var_dump($map_location); ?><br>
                <?php echo $map_location['markers'][0]['lng']; ?><br>
                <?php echo $map_location['markers'][0]['lat']; ?><br>
                <?php echo $map_location['address'] ?>
                <div id="map"></div>
                   <style>

                        #map { height: 360px; }
                    </style>     
                    <script>
                            // var map = L.map('map').setView([51.505, -0.09], 13);
                            var map = L.map('map').setView([
                                <?php echo $map_location['markers'][0]['lat']; ?>,
                                <?php echo $map_location['markers'][0]['lng']; ?>                                
                                ], 13);
                                
                            L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
                            maxZoom: 19,
                            attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
                        }).addTo(map);

                        var marker = L.marker([
                                <?php echo $map_location['markers'][0]['lat']; ?>,
                                <?php echo $map_location['markers'][0]['lng']; ?>
                            ]).addTo(map);


                    </script>
                <!-- End HTMl MAP -->                
                <div class="acf-map">
                        <div class="marker"
                            data-lng="<?php echo $map_location['markers'][0]['lng']; ?>"
                            data-lat="<?php echo $map_location['markers'][0]['lat']; ?>"
                        >
                            <h3><?php the_title(); ?></h3>
                            <?php echo $map_location['address'] ?>
                        </div>
                
                </div>
            </div>
        <?php } ?>
        
    <?php
    get_footer()
    ?>
