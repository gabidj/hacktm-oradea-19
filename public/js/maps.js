var data;
console.log($("#map-container"));

function moveMapToBerlin(map){
    map.setCenter({lat:47.063711 , lng:21.930863});
    map.setZoom(14);
}

function addMarkersToMap(map) {
    for (var i = 0; i < sportWithVenues.length; i++) {
        console.log(data.data.venues[i].name);
        var venue = data.data.venues[i];
        addMarker(map, {type:data.data.name, lat:venue.latitude, long:venue.longitude,
            name:venue.name, price:venue.price, startHour: venue.startHour,
            endHour: venue.endHour});
    }
}

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

    // add 'tap' event listener, that opens info bubble, to the group
    group.addEventListener('tap', function (evt) {
        // event target is the marker itself, group is a parent event target
        // for all objects that it contains
        var bubble =  new H.ui.InfoBubble(evt.target.getPosition(), {
            // read custom data
            content: evt.target.getData()
        });
        // show info bubble
        ui.addBubble(bubble);
    }, false);

    addMarkerToGroup(marker, group,
        '<div class="infoTitle">' +info.name+ '' +
        '</div><div class="infoDesc"> price: '+info.price+' ron <br> Mon-Sun: '+info.startHour+':00-'+info.endHour+':00 <a class="bookBtn" href="#">Book</a></div>');

    //map.addObject(marker);
}


//API
var request = new XMLHttpRequest()

request.open('GET', 'http://hacktm.local/api/category/football', true)

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


request.send()



var platform = new H.service.Platform({
    'app_id': '6YWqAz92yiVW4TmBg3ap',
    'app_code': '2Njcxr7YQlMlNSSgJwckjQ'
});

// Obtain the default map types from the platform object:
var defaultLayers = platform.createDefaultLayers();

// Instantiate (and display) a map object:
$('document').ready(function(){
    var map = new H.Map(document.getElementById('map-container'), defaultLayers.normal.map);

    var behavior = new H.mapevents.Behavior(new H.mapevents.MapEvents(map));

    var ui = H.ui.UI.createDefault(map, defaultLayers);


    moveMapToBerlin(map);
//addMarkersToMap(map);

    $('head').append('<link rel="stylesheet" href="https://js.api.here.com/v3/3.0/mapsjs-ui.css" type="text/css" />');



});

// /**
//  * Moves the map to display over Berlin
//  *
//  * @param  {H.Map} map      A HERE Map instance within the application
//  */
// function moveMapToBerlin(map){
//   map.setCenter({lat:52.5159, lng:13.3777});
//   map.setZoom(14);
// }
//



//
// /**
//  * Boilerplate map initialization code starts below:
//  */
//
// //Step 1: initialize communication with the platform
// var platform = new H.service.Platform({
//   app_id: 'DemoAppId01082013GAL',
//   app_code: 'AJKnXv84fjrb0KIHawS0Tg',
//   useCIT: true,
//   useHTTPS: true
// });
// var defaultLayers = platform.createDefaultLayers();
// console.log(document.getElementById('map-container'))
// //Step 2: initialize a map  - not specificing a location will give a whole world view.
// var map = new H.Map(document.getElementById('map-container'), defaultLayers.normal.map);
//
// //Step 3: make the map interactive
// // MapEvents enables the event system
// // Behavior implements default interactions for pan/zoom (also on mobile touch environments)
// var behavior = new H.mapevents.Behavior(new H.mapevents.MapEvents(map));
//
// // Create the default UI components
// var ui = H.ui.UI.createDefault(map, defaultLayers);
//
// // Now use the map as required...
// moveMapToBerlin(map);
//
// $('head').append('<link rel="stylesheet" href="https://js.api.here.com/v3/3.0/mapsjs-ui.css" type="text/css" />');
