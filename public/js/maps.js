var data;
var ui;
var behavior;
var currentMap;
var map;
var routeInstructionsContainer;

function moveMapToOradea(map){
    map.setCenter({lat:47.063711 , lng:21.930863});
    map.setZoom(13);
}

function addMarkersToMap(map) {
    for (var i = 0; i < data.sportWithVenues.venues.length; i++) {
        var venue = data.sportWithVenues.venues[i];
        addMarker(map, {type:data.sportWithVenues.name, lat:venue.latitude, long:venue.longitude,
            name:venue.name, price:venue.price, startHour: venue.startHour,
            endHour: venue.endHour});
    }
}

function addCurrentMarker(map, platform) {
    hardcodeElem = document.getElementById("hardcodeCoord")
    lat = hardcodeElem.innerHTML.split(" - ")[0]
    long = hardcodeElem.innerHTML.split(" - ")[1]
    addMarker(map, {type:"football", lat:lat, long:long,
        name:"", price:"", startHour: "",
        endHour: ""})
    hardcodeElem.style.display = "none";
    map.setCenter({lat:lat , lng:long});
    map.setZoom(14);

    routing(platform, lat, long);

    var myLocation = new H.map.Marker({lat:47.046203, lng:21.917236});
    map.addObject(myLocation);
    //////
    // addMarker(map, {type:data.sportWithVenues.name, lat:venue.latitude, long:venue.longitude,
    //     name:venue.name, price:venue.price, startHour: venue.startHour,
    //     endHour: venue.endHour});
}

// ROUTING
function routing (platform, lat, long) {

  var router = platform.getRoutingService(),
    routeRequestParams = {
      mode: 'fastest;car',
      representation: 'display',
      routeattributes : 'waypoints,summary,shape,legs',
      maneuverattributes: 'direction,action',
      waypoint0: '47.046203,21.917236', // Brandenburg Gate
      waypoint1: '' + lat + ',' + long + ''  // Friedrichstraße Railway Station
    };


  router.calculateRoute(
    routeRequestParams,
    onSuccess,
    onError
  );
}

function onSuccess(result) {
  var route = result.response.route[0];
 /*
  * The styling of the route response on the map is entirely under the developer's control.
  * A representitive styling can be found the full JS + HTML code of this example
  * in the functions below:
  */
  addRouteShapeToMap(route);
  addManueversToMap(route);

  addWaypointsToPanel(route.waypoint);
  addManueversToPanel(route);
  addSummaryToPanel(route.summary);
  // ... etc.
}

function onError(error) {
  alert('Ooops!');
}
function addRouteShapeToMap(route){
  var strip = new H.geo.Strip(),
    routeShape = route.shape,
    polyline;

  routeShape.forEach(function(point) {
    var parts = point.split(',');
    strip.pushLatLngAlt(parts[0], parts[1]);
  });

  polyline = new H.map.Polyline(strip, {
    style: {
      lineWidth: 4,
      strokeColor: 'rgba(0, 128, 255, 0.7)'
    }
  });
  // Add the polyline to the map
  map.addObject(polyline);
  // And zoom to its bounding rectangle
  map.setViewBounds(polyline.getBounds(), true);
}


/**
 * Creates a series of H.map.Marker points from the route and adds them to the map.
 * @param {Object} route  A route as received from the H.service.RoutingService
 */
function addManueversToMap(route){
  var svgMarkup = '<svg width="18" height="18" ' +
    'xmlns="http://www.w3.org/2000/svg">' +
    '<circle cx="8" cy="8" r="8" ' +
      'fill="#1b468d" stroke="white" stroke-width="1"  />' +
    '</svg>',
    dotIcon = new H.map.Icon(svgMarkup, {anchor: {x:8, y:8}}),
    group = new  H.map.Group(),
    i,
    j;

  // Add a marker for each maneuver
  for (i = 0;  i < route.leg.length; i += 1) {
    for (j = 0;  j < route.leg[i].maneuver.length; j += 1) {
      // Get the next maneuver.
      maneuver = route.leg[i].maneuver[j];
      // Add a marker to the maneuvers group
      var marker =  new H.map.Marker({
        lat: maneuver.position.latitude,
        lng: maneuver.position.longitude} ,
        {icon: dotIcon});
      marker.instruction = maneuver.instruction;
      group.addObject(marker);
    }
  }

  group.addEventListener('tap', function (evt) {
    map.setCenter(evt.target.getPosition());
    openBubble(
       evt.target.getPosition(), evt.target.instruction);
  }, false);

  // Add the maneuvers group to the map
  map.addObject(group);
}


/**
 * Creates a series of H.map.Marker points from the route and adds them to the map.
 * @param {Object} route  A route as received from the H.service.RoutingService
 */
function addWaypointsToPanel(waypoints){



  var nodeH3 = document.createElement('h3'),
    waypointLabels = [],
    i;


   for (i = 0;  i < waypoints.length; i += 1) {
    waypointLabels.push(waypoints[i].label)
   }

   nodeH3.textContent = waypointLabels.join(' - ');

  // routeInstructionsContainer.innerHTML = '';
  // routeInstructionsContainer.appendChild(nodeH3);
}

/**
 * Creates a series of H.map.Marker points from the route and adds them to the map.
 * @param {Object} route  A route as received from the H.service.RoutingService
 */
function addSummaryToPanel(summary){
  var summaryDiv = document.createElement('div'),
   content = '';
   content += '<b>Total distance</b>: ' + summary.distance  + 'm. <br/>';
   content += '<b>Travel Time</b>: ' + summary.travelTime.toMMSS() + ' (in current traffic)';


  summaryDiv.style.fontSize = 'small';
  summaryDiv.style.marginLeft ='5%';
  summaryDiv.style.marginRight ='5%';
  summaryDiv.innerHTML = content;
  routeInstructionsContainer.appendChild(summaryDiv);
}

/**
 * Creates a series of H.map.Marker points from the route and adds them to the map.
 * @param {Object} route  A route as received from the H.service.RoutingService
 */
function addManueversToPanel(route){



  var nodeOL = document.createElement('ol'),
    i,
    j;

  nodeOL.style.fontSize = 'small';
  nodeOL.style.marginLeft ='5%';
  nodeOL.style.marginRight ='5%';
  nodeOL.className = 'directions';

     // Add a marker for each maneuver
  for (i = 0;  i < route.leg.length; i += 1) {
    for (j = 0;  j < route.leg[i].maneuver.length; j += 1) {
      // Get the next maneuver.
      maneuver = route.leg[i].maneuver[j];

      var li = document.createElement('li'),
        spanArrow = document.createElement('span'),
        spanInstruction = document.createElement('span');

      spanArrow.className = 'arrow '  + maneuver.action;
      spanInstruction.innerHTML = maneuver.instruction;
      li.appendChild(spanArrow);
      li.appendChild(spanInstruction);

      nodeOL.appendChild(li);
    }
  }

  // routeInstructionsContainer.appendChild(nodeOL);
}


Number.prototype.toMMSS = function () {
  return  Math.floor(this / 60)  +' minutes '+ (this % 60)  + ' seconds.';
}

//ROUTING End


function addMarkerToGroup(marker, group, html) {
    marker.setData(html);
    group.addObject(marker);
}


function addMarker(map, info) {
    var domElement = document.createElement('img');

    if (info.type == "football") {
        domElement.src = '/img/pin_football.png';
    } else if (info.type == "basket") {
        domElement.src = '/img/pin_basket.png';
    } else if (info.type == "volley") {
        domElement.src = '/img/pin_volley.png';
    } else if (info.type == "tennis") {
        domElement.src = '/img/pin_tennis.png';
    }

    domElement.className = "marker";

    //interaction
    function changeOpacity(evt) {
        evt.target.style.opacity = 0.6;
    };

    function changeOpacityToOne(evt) {
        evt.target.style.opacity = 1;
    };

    //create dom icon and add/remove opacity listeners
    var domIcon = new H.map.DomIcon(domElement, {
        // the function is called every time marker enters the viewport
        onAttach: function(clonedElement, domIcon, domMarker) {
            clonedElement.addEventListener('mouseover', changeOpacity);
            clonedElement.addEventListener('mouseout', changeOpacityToOne);
        },
        // the function is called every time marker leaves the viewport
        onDetach: function(clonedElement, domIcon, domMarker) {
            clonedElement.removeEventListener('mouseover', changeOpacity);
            clonedElement.removeEventListener('mouseout', changeOpacityToOne);
        }
    });

    var marker = new H.map.DomMarker({lat:info.lat, lng:info.long}, {
        icon: domIcon
    });



    ///experiemental
    var group = new H.map.Group();
    map.addObject(group);

    if (currentMap == 0) {
        group.addEventListener('tap', function (evt) {
            var bubble =  new H.ui.InfoBubble(evt.target.getPosition(), {
                content: evt.target.getData()
            });
            ui.addBubble(bubble);
        }, false);
    }

    addMarkerToGroup(marker, group,
        '<div class="infoTitle">' +info.name+ '' +
        '</div><div class="infoDesc"> price: '+info.price+' ron <br> Mon-Sun: '+info.startHour+':00-'+info.endHour+':00 <a class="bookBtn" href="#">Book</a></div>');
}



$('document').ready(function(){

    var platform = new H.service.Platform({
        'app_id': '6YWqAz92yiVW4TmBg3ap',
        'app_code': '2Njcxr7YQlMlNSSgJwckjQ'
    });

    var defaultLayers = platform.createDefaultLayers();

    currentMap = 0;

    // mapElement = document.getElementById("map-container");
    // if (mapElement == null) {
    //     mapElement = document.getElementById("booking-map-container");
    //     currentMap = 1;
    // }


    mapElement = document.getElementById("map-container");

    if (mapElement == null) {
        console.log("mapElement is not found");
        exit();
    }

    if ( $('#map-container').attr('name') == "bookingMap") {
        currentMap = 1;
        console.log("Booking map found")
    }

    map = new H.Map(mapElement, defaultLayers.normal.map);
    behavior = new H.mapevents.Behavior(new H.mapevents.MapEvents(map));
    ui = H.ui.UI.createDefault(map, defaultLayers);

    routeInstructionsContainer = document.getElementById('routingInstructions');

    //API
    if (currentMap == 0) {
        var request = new XMLHttpRequest();

        request.open('GET', 'http://hacktm.local/api/category/football', true);

        request.onload = function() {
            // Begin accessing JSON data here
            var api = JSON.parse(this.response)
            if (request.status >= 200 && request.status < 400) {
                data = api;
                console.log(data);
                addMarkersToMap(map);
            } else {
                console.log('error')
            }
        }

        request.send();

        moveMapToOradea(map);
    } else {
        addCurrentMarker(map, platform);
    }


    $('head').append('<link rel="stylesheet" href="https://js.api.here.com/v3/3.0/mapsjs-ui.css" type="text/css" />');

});
