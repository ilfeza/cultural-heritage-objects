let center = [48.8866527839977, 2.34310679732974];

function init() {
    let map = new ymaps.Map('map-test', {
        center: center,
        zoom: 17
    });

    map.controls.remove('geolocationControl');
    map.controls.remove('searchControl');
    map.controls.remove('trafficControl');
    map.controls.remove('typeSelector');
    map.controls.remove('fullscreenControl');
    map.controls.remove('zoomControl');
    map.controls.remove('rulerControl');
    //map.behaviors.disable(['scrollZoom']);

    // Добавление меток на карту из массива points
    for (let i = 0; i < points.length; i++) {
        let point = points[i];
        let placemark = new ymaps.Placemark([point.x, point.y]);
        map.geoObjects.add(placemark);
    }
}

ymaps.ready(init);
