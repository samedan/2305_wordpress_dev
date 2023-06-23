<?php
get_header();
pageBanner(array(
    'title' => 'Our Campuses',
    'subtitle' => 'We have several conviniently located campuses.'//,
    //'photo' => get_theme_file_uri('/images/ocean.jpg')
));
$map_location = get_field('map_location');
?>
 
<div class="container container--narrow page-section">
<div id="map"></div>
<style>

                        #map { height: 360px; }
                    </style>   
                    <script>
                      var map = L.map('map').setView([
                                <?php echo $map_location['markers'][0]['lat']; ?>,
                                <?php echo $map_location['markers'][0]['lng']; ?>                                
                                ], 3);
                                
                            L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
                            maxZoom: 14,
                            attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
                        }).addTo(map);

                    </script>
    <div class="acf-map">
        <?php
            while(have_posts()) {
                the_post();
                $map_location_post = get_field('map_location');
                print_r($map_location_post);
                ?>
                <script>
                  var marker = L.marker([
                      <?php echo $map_location_post['markers'][0]['lat']; ?>,
                      <?php echo $map_location_post['markers'][0]['lng']; ?>
                                    ]).addTo(map)
                                    .bindPopup('<a href="<?php echo the_permalink(); ?>"><h3><?php echo the_title() ?></h3></a><?php echo $map_location_post['address'] ?>');
                                    ;
                </script>
              <div class="marker"
                  data-lng="<?php echo $map_location_post['markers'][1]['lng']; ?>"
                  data-lat="<?php echo $map_location_post['markers'][1]['lat']; ?>"
              >
               
              </div> 
              <h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
                  <?php echo $map_location_post['address'] ?>
        <?php } ?>
                    <script>
        var map = L.map('map').setView([44.6499282, 22.6327532], 14);
L.tileLayer('http://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png').addTo(map);
var coordinates = [
    [44.649, 22.632],
    [44.650, 22.642],
    [44.652, 22.632]
];
var layerGroup = L.layerGroup().addTo(map);
for (i = 0; i < coordinates.length; i++) {
    marker = L.marker([coordinates[i][0], coordinates[i][1]]);
    layerGroup.addLayer(marker);
}
var overlay = {'markers': layerGroup};
L.control.layers(null, overlay).addTo(map);
</script>
    </div>
</div>
    
<?php
get_footer()
?>
