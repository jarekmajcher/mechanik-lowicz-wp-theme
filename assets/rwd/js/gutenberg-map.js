import { MarkerClusterer } from "@googlemaps/markerclusterer";

/**
 * Locations Map (Google Maps)
 */
class LocationsMap {
  constructor(element, locations, options) {
    this.element = element;
    this.map = null;
    this.markers = {};
    this.markerCluster = null;
    this.locations = locations;
    this.options = {
      center: new google.maps.LatLng(options.lat, options.lng),
      zoom: parseInt(options.zoom),
      maxZoom: 18,
    };

    this.createMap(element);
    this.createMarkers();
    //this.groupMarkers();
    //this.centerMarkers();
  }

  createMap(element) {
    this.map = new google.maps.Map(element, {
      zoom: this.options.zoom,
      maxZoom: this.options.maxZoom,
      center: this.options.center,
      mapTypeId: google.maps.MapTypeId.ROADMAP,
      mapTypeControl: false,
      streetViewControl: false,
      rotateControl: false,
      fullscreenControl: false,
      styles: [
        {
          "featureType": "all",
          "elementType": "all",
          "stylers": [
            {
              "color": "#fdfdfd"
            }
          ]
        },
        {
          "featureType": "all",
          "elementType": "geometry",
          "stylers": [
            {
              "color": "#fdfdfd"
            }
          ]
        },
        {
          "featureType": "all",
          "elementType": "labels",
          "stylers": [
            {
              "color": "#fdfdfd"
            }
          ]
        },
        {
          "featureType": "all",
          "elementType": "labels.text.fill",
          "stylers": [
            {
              "color": "#716558"
            }
          ]
        },
        {
          "featureType": "all",
          "elementType": "labels.icon",
          "stylers": [
            {
              "visibility": "off"
            }
          ]
        },
        {
          "featureType": "poi.park",
          "elementType": "geometry",
          "stylers": [
            {
              "lightness": 20
            }
          ]
        },
        {
          "featureType": "road",
          "elementType": "geometry",
          "stylers": [
            {
              "lightness": -5
            },
          ]
        },
        {
          "featureType": "road",
          "elementType": "geometry.stroke",
          "stylers": [
            {
              "lightness": 25
            }
          ]
        },
        {
          "featureType": "water",
          "elementType": "all",
          "stylers": [
            {
              "color": "#9eb6d5"
            }
          ]
        }
      ]
    });
  }

  createMarkers() {
    let infowindow = new google.maps.InfoWindow();

    for (var i = 0; i < this.locations.length; i++) {
      let location = this.locations[i];

      let marker = new google.maps.Marker({
        position: new google.maps.LatLng(location.lat, location.lng),
        icon: this.options.icon,
        map: this.map,
      });

      this.markers[location.id] = marker;

      google.maps.event.addListener(marker, 'click', (function(marker, i) {
        return function() {
          infowindow.setContent(location.content);
          infowindow.open(this.map, marker);
        }
      })(marker, i));
    }
  }

  groupMarkers() {
    let that = this;

    this.markerCluster = new MarkerClusterer(this.map, this.markers, this.options.cluster);

    for(const [key, marker] of Object.entries(that.markers)) {
      google.maps.event.addListener(marker, 'visible_changed', function() {
        if (marker.getVisible()) {
          that.markerCluster.addMarker(marker, true);
        }
        else {
          that.markerCluster.removeMarker(marker, true);
        }
      });
    }
  }

  centerMarkers() {
    let bounds = new google.maps.LatLngBounds(null);

    for(const [key, marker] of Object.entries(this.markers)) {
      if(marker.getVisible()) {
        bounds.extend(marker.getPosition());
      }
    }

    if(!bounds.isEmpty()) {
      this.map.fitBounds(bounds);
    }
    else {
      this.map.setCenter(this.options.center);
      this.map.setZoom(this.options.zoom);
    }
  }

  showOrHide(id, visible) {
    this.markers[id].setVisible(visible);
    this.markerCluster.repaint();
  }
}

window.initMap = function() {

  let maps = document.querySelectorAll('.gMap');

  if(maps.length > 0) {
    maps.forEach(function (map, index) {

      let items = map.querySelectorAll('.gMap__item');

      if (items.length > 0) {
        let locations = [];

        items.forEach(function (item, index) {
          locations.push({
            id: 'location_id_' + index,
            lat: item.dataset.latitude,
            lng: item.dataset.longitude,
            content: item.innerHTML
          });
        });

        let options = {
          lat: map.dataset.latitude,
          lng: map.dataset.longitude,
          zoom: map.dataset.zoom
        }
        new LocationsMap(map, locations, options);
      }
    });
  }
};
