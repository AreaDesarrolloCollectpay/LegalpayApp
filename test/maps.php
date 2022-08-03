<!DOCTYPE html>
<html>
  <head>
    <meta name="viewport" content="initial-scale=1.0, user-scalable=no">
    <meta charset="utf-8">
    <title>Marker Clustering</title>
    <style>
      /* Always set the map height explicitly to define the size of the div
       * element that contains the map. */
      #map {
        height: 100%;
      }
      /* Optional: Makes the sample page fill the window. */
      html, body {
        height: 100%;
        margin: 0;
        padding: 0;
      }
    </style>
  </head>
  <body>
    <div id="map"></div>
    <button onclick="myFunction()">test</button>
<!--    <script>
        var markers = [];
        var map;
        var markerCluster;
        var locations = [];

function myFunction() {
//    map.clear();
    //markers = [];
   // clearMarkers();
   //setMapOnAll(null);
  //markers = [];
  //map.clear();
  //map.setAllMap(null);
   //markers = [];
   markerCluster.removeMarkers(markers);
   markers = [];
   
   locations = [
        {lat: -31.563910, lng: 147.154312,title : '111'},
        {lat: -33.718234, lng: 150.363181,title : '222'},
   ];
   console.log(locations);
   locations.map(function(location, i) {
          var marker = new google.maps.Marker({
            position: location,
            label: location.title,
            map: map
          });
          markers.push(marker);
        });
   markerCluster = new MarkerClusterer(map, markers,
            {imagePath: 'https://developers.google.com/maps/documentation/javascript/examples/markerclusterer/m'});
}
      function initMap() {

         map = new google.maps.Map(document.getElementById('map'), {
          zoom: 3,
          center: {lat: -28.024, lng: 140.887}
        });

        // Create an array of alphabetical characters used to label the markers.
        var labels = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';

        // Add some markers to the map.
        // Note: The code uses the JavaScript Array.prototype.map() method to
        // create an array of markers based on a given "locations" array.
        // The map() method here has nothing to do with the Google Maps API.
        locations.map(function(location, i) {
          var marker = new google.maps.Marker({
            position: location,
            label: location.title,
            map: map
          });
          markers.push(marker);
        });
        
//        for (i = 0; i < locations.length; i++) {  
//        marker = new google.maps.Marker({
//          position: new google.maps.LatLng(locations[i].lat, locations[i].lng),
//          map: map
//        });
//
//        google.maps.event.addListener(marker, 'click', (function(marker, i) {
//          return function() {
//            infowindow.setContent(locations[i][0]);
//            infowindow.open(map, marker);
//          }
//        })(marker, i));
//      }
        
        

        // Add a marker clusterer to manage the markers.
        markerCluster = new MarkerClusterer(map, markers,
            {imagePath: 'https://developers.google.com/maps/documentation/javascript/examples/markerclusterer/m'});
      }
      
      
      locations = [
        {lat: -31.563910, lng: 147.154312,title : '1'},
        {lat: -33.718234, lng: 150.363181,title : '2'},
        {lat: -33.727111, lng: 150.371124,title : '3'},
        {lat: -33.848588, lng: 151.209834,title : '4'},
        {lat: -33.851702, lng: 151.216968,title : '5'},
        {lat: -34.671264, lng: 150.863657,title : '6'},
        {lat: -35.304724, lng: 148.662905,title : '7'},
        {lat: -36.817685, lng: 175.699196,title : '8'},
        {lat: -36.828611, lng: 175.790222,title : '9'},
        {lat: -37.750000, lng: 145.116667,title : '10'},
        {lat: -37.759859, lng: 145.128708,title : '11'},
        {lat: -37.765015, lng: 145.133858,title : '12'},
        {lat: -37.770104, lng: 145.143299,title : '13'},
        {lat: -37.773700, lng: 145.145187,title : '14'},
        {lat: -37.774785, lng: 145.137978,title : '15'},
        {lat: -37.819616, lng: 144.968119,title : '16'},
        {lat: -38.330766, lng: 144.695692,title : '17'},
        {lat: -39.927193, lng: 175.053218,title : '18'},
        {lat: -41.330162, lng: 174.865694,title : '19'},
        {lat: -42.734358, lng: 147.439506,title : '20'},
        {lat: -42.734358, lng: 147.501315,title : '21'},
        {lat: -42.735258, lng: 147.438000,title : '22'},
        {lat: -43.999792, lng: 170.463352,title : '23'}
      ]
    </script>-->
    <div id="can_widget_container"></div><script type="text/javascript" src="http://api.canvanizer.com/api/widget.js?v=1&canvas_id=rPETSJ7WMFNmx&mode=compact-nobg&revision=sync"></script>
<!--    <div id="can_widget_container"></div><script type="text/javascript" src="http://api.canvanizer.com/api/widget.js?v=1&canvas_id=rtSrXWqCrXW6h&mode=compact-nobg&revision=sync"></script>-->
<!--    <script src="https://developers.google.com/maps/documentation/javascript/examples/markerclusterer/markerclusterer.js"></script>
    <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBzcBlS39ZkGbWVteA5CbcBiB0GBpVWCvo&callback=initMap"></script>-->
  </body>
</html>