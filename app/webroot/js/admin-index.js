$(document).ready(function () {
    $("#mySidenav").addClass('noscroll'); // solve scrollbar issue in Edge

    $('#from').datepicker({
        'format': 'dd-mm-yyyy'
    }).on('changeDate', function (ev) {
        $('.datepicker').hide();
    });

    $('#to').datepicker({
        'format': 'dd-mm-yyyy'
    }).on('changeDate', function (ev) {
        $('.datepicker').hide();
    });

    $('#from').keyup(function (e) {
        if (e.keyCode == 8 || e.keyCode == 46) {
            $(this).val('');
        }
    });

    $('#to').keyup(function (e) {
        if (e.keyCode == 8 || e.keyCode == 46) {
            $(this).val('');
        }
    });

    $('#show-user').click(function () {
        $('#show-user-icon').toggleClass('glyphicon-plus');
        $('#show-user-icon').toggleClass('glyphicon-minus');
    });

    $('#germany-zoomout').click(function () {
        zoom(initLatLng.lat, initLatLng.lng, zoomLevel);
    });
});

var map = null;
var currentInfoWindow = null;

function initMap() {
    map = new google.maps.Map(document.getElementById('map'), {
        zoom: zoomLevel,
        center: initLatLng,
        streetViewControl: false,
        mapTypeId: 'hybrid',
        mapTypeControl: true,
        mapTypeControlOptions: {
            style: google.maps.MapTypeControlStyle.HORIZONTAL_BAR,
            position: google.maps.ControlPosition.BOTTOM_CENTER,
            mapTypeIds: ['roadmap', 'hybrid']
        },
        fullscreenControl: false,
        styles: [
            {
                featureType: "poi",
                stylers: [{visibility: "off"}]
            },
            {
                featureType: 'transit',
                stylers: [{visibility: 'off'}]
            }

        ]
    });

    map.data.setStyle({
        fillColor: 'red',
        strokeWeight: 1
    });

    // creating zoom out buttons
    var countryZoomout = document.getElementById('country-zoomout');
    map.controls[google.maps.ControlPosition.BOTTOM_CENTER].push(countryZoomout);

    // creating legend for the map
    var legend = document.getElementById('legend');
    var i = 0;
    for (var key in icons) {
        var type = icons[key];
        var name = type.name;
        var icon = type.icon;
        var div = document.createElement('div');
        div.innerHTML = '<img src="' + icon + '"> ' + name;
        if (i > 0) {
            div.innerHTML = '<div class="separator"></div>' + div.innerHTML;
        }
        i++;

        legend.appendChild(div);
    }

    map.controls[google.maps.ControlPosition.RIGHT_BOTTOM].push(legend);

    filterUsersBoundaries();
    loadUsers();
}

function filterUsersBoundaries() {
    // removing internal users' boundary requests from map
    var userIds = users.map(function (user) {
        return user.User.id;
    });

    boundaries = boundaries.filter(function (boundary) {
        return userIds.indexOf(boundary.user_id) != -1;
    });
}

function clearMarkers() {
    if (markerCluster != null) {
        markerCluster.clearMarkers();
    }

    for (var i = 0; i < markers.length; i++) {
        markers[i].setMap(null);
    }

    markers = [];
}

function zoom(lat, lng, zoom) {
    zoom = (zoom === undefined) ? 17 : zoom;
    var latLng = new google.maps.LatLng(lat, lng);
    map.setZoom(zoom);
    map.panTo(latLng);
}

function openNav() {
    $("#mySidenav").removeClass('noscroll');
    document.getElementById("mySidenav").style.width = "400px";
}

function closeNav() {
    document.getElementById("mySidenav").style.width = "0";
    $("#mySidenav").addClass('noscroll'); // solve scrollbar issue in Edge
}

function searchUsers() {
    var input, filter, table, tr, td, i;
    input = document.getElementById("user-search");
    filter = input.value.toUpperCase();
    table = document.getElementById("users-table");
    tr = table.getElementsByTagName("tr");
    for (i = 0; i < tr.length; i++) {
        td = tr[i].getElementsByTagName("td")[1];
        if (td) {
            if (td.innerHTML.toUpperCase().indexOf(filter) > -1) {
                tr[i].style.display = "";
            } else {
                tr[i].style.display = "none";
            }
        }
    }
}

function showWait(msg) {
    msg = (typeof msg === "undefined") ? 'Please Wait...' : msg;

    $('#wait-message').html(msg);
    $('#wait-dialog').modal('show');
}

function hideWait() {
    $('#wait-dialog').modal('hide');
}