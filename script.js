var myMap;
var circle;

ymaps.ready(init);

function init() {
    var map = new ymaps.Map('map-test', {
        center: [55.755863, 37.617700],
        zoom: 10
    });
    map.controls.remove('searchControl');
    map.controls.remove('trafficControl');
    map.controls.remove('typeSelector');
    map.controls.remove('fullscreenControl');
    map.controls.remove('zoomControl');
    map.controls.remove('rulerControl');
    map.controls.remove('geolocationControl');

    var clusterer = new ymaps.Clusterer({
        clusterize: true,
        gridSize: 200,
        clusterDisableClickZoom: true,
        clusterBalloonContentLayout: 'cluster#balloonCarousel',
        clusterBalloonPanelMaxMapArea: 0,
        clusterIcons: [
            {
                href: 'images/marker.svg',
                size: [40, 40],
                offset: [-20, -20]
            },
            {
                href: 'images/marker.svg',
                size: [60, 60],
                offset: [-30, -30]
            }],
        clusterIconContentLayout: null
    });

    map.geoObjects.add(clusterer);

    var clickListener = null;

    document.getElementById('getCoordinatesBtn').addEventListener('click', function () {
        if (clickListener) {
            map.events.remove('click', clickListener);
        }

        clickListener = map.events.add('click', function (e) {
            var coords = e.get('coords');
            var latitudeInput = document.getElementById('latitudeInput');
            var longitudeInput = document.getElementById('longitudeInput');

            latitudeInput.value = coords[0].toPrecision(6);
            longitudeInput.value = coords[1].toPrecision(6);

            if (circle) {
             
                map.geoObjects.remove(circle);
            }

            
            var radius = parseFloat(document.getElementById('radiusInput').value);
            circle = new ymaps.Circle([coords, radius], {
             
            }, {
          
                fillColor: "#DB709377",
                strokeColor: "#990066",
                strokeOpacity: 0.8,
                strokeWidth: 5
            });

          
            map.geoObjects.add(circle);

            map.events.remove('click', clickListener);
            clickListener = null;
        });
    });

    fetch('get_coordinates.php')
        .then(response => response.json())
        .then(data => {
            var features = data.features;

            var promises = features.map(feature => {
                var coordinates = feature.geometry.coordinates.map(parseFloat);
                var properties = feature.properties;

                return new Promise((resolve, reject) => {
                    var balloonContent = '<div class="balcont"><h3>' + properties.balloonContentHeader + '</h3>';
                    balloonContent += '<p>Адрес: ' + properties.balloonContentBody + '</p>';
                    balloonContent += '</div>';

                    var placemark = new ymaps.Placemark(coordinates, properties, {
                        balloonContentBody: balloonContent,
                        iconLayout: 'default#image',
                        iconImageHref: 'images/marker.svg',
                        iconImageSize: [40, 40],
                        iconImageOffset: [-19, -44]
                    });

                    placemark.events.add('click', function (e) {
                        map.balloon.open(placemark.geometry.getCoordinates(), placemark.properties.get('balloonContentBody'));
                    });

                    resolve(placemark);
                });
            });

            Promise.all(promises)
                .then(geoObjects => {
                    clusterer.add(geoObjects);
                })
                .catch(error => {
                    console.error('Error creating placemarks:', error);
                });
        })
        .catch(error => {
            console.error('Error fetching data:', error);
        }
    );

    document.getElementById('radiusOnMap').addEventListener('click', function (event) {
        event.preventDefault();
    
        var radiusInKm = parseFloat(document.getElementById('radiusInput').value);
        var radiusInMeters = radiusInKm * 1000; 
    
        if (circle) {
           
            map.geoObjects.remove(circle);
        }
    
     
        var centerCoords = [
            parseFloat(document.getElementById('latitudeInput').value),
            parseFloat(document.getElementById('longitudeInput').value)
        ];
    
        circle = new ymaps.Circle([centerCoords, radiusInMeters], {
        }, {
            fillColor: "#DB709377",
            strokeColor: "#990066",
            strokeOpacity: 0.8,
            strokeWidth: 5
        });
    
        
        map.geoObjects.add(circle);
    });
    
    
}
