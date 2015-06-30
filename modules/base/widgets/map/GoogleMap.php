<?php
/**
 * Created by PhpStorm.
 * User: sz
 * Date: 23.06.15
 * Time: 13:16
 */

namespace modules\base\widgets\map;

use Ivory\GoogleMap\MapTypeId;
use Ivory\GoogleMap\Overlays\Marker;
use Ivory\GoogleMap\Places\Autocomplete;
use Ivory\GoogleMap\Places\AutocompleteComponentRestriction;
use Ivory\GoogleMap\Places\AutocompleteType;
use yii\bootstrap\Widget;
use yii\web\View;

class GoogleMap extends Widget
{

    public $id_latitude;

    public $id_longitude;

    public $latitude;

    public $longitude;

    private $_map;

    public function init(){
        $this->registerAssets();

        $this->latitude = $this->latitude && is_numeric($this->latitude) ? $this->latitude : 42;
        $this->longitude = $this->longitude && is_numeric($this->longitude) ? $this->latitude : 14;
    }

    public function registerAssets(){
        $this->_map = new \Ivory\GoogleMap\Map();

        $map = $this->_map;
        $map->setPrefixJavascriptVariable('map_');
        $map->setHtmlContainerId('map_canvas');

        $this->_map = $map;
        $view = $this->getView();
        Asset::register($view);
        $view->registerJS('
            var markers = [];
        ', View::POS_HEAD);

        /*
         * функция добавления маркера на карту
         * */
        $view->registerJs('
            var addMarker = function(map, position){
                if(markers["userMarker"] !== undefined)
                    markers["userMarker"].setMap(null);
                markers["userMarker"] = new google.maps.Marker({
                    position: position,
                    map: map
                });

                var defaultMarkers = '.$this->_map->getJavascriptVariable().'_container.markers;console.log(defaultMarkers);
                for(i in defaultMarkers){
                    marker = defaultMarkers[i];
                    marker.setMap(null);
                }

                map.panTo(position);
            }
        ', $view::POS_END);
    }

    public function run(){
        $map = $this->fillMapParams();

        $autocomplete = $this->addAutocomplete();

        $instance = $map->getJavascriptVariable();
        $event = new \Ivory\GoogleMap\Events\Event();
        $event->setInstance($instance);
        $event->setEventName('click');
        $handle = 'function(event){
            var map = '.$map->getJavascriptVariable().';
            var cont = map + "_container";
            var position = event.latLng;
            addMarker(map, position);
        }';
        $event->setHandle($handle);
        $map->getEventManager()->addDomEvent($event);

        return $this->render('index', [
            'map' => $map,
            'autocomplete' => $autocomplete,
            'event' => $event,
            'id_latitude' => $this->id_latitude,
            'id_longitude' => $this->id_longitude,
        ]);

    }

    public function addAutocomplete(){
        $autocomplete = new Autocomplete();
        $autocomplete->setPrefixJavascriptVariable('place_autocomplete_');
        $autocomplete->setInputId('place_input');
        $autocomplete->setInputAttribute('class', 'form-control');
        $autocomplete->setValue('Rome');
        $autocomplete->setTypes(array(AutocompleteType::CITIES));
        $autocomplete->setComponentRestrictions(array(AutocompleteComponentRestriction::COUNTRY => 'it'));
        $autocomplete->setBound(-2.1, -3.9, 2.6, 1.4, true, true);
        $autocomplete->setAsync(false);
        $autocomplete->setLanguage('en');

        return $autocomplete;
    }

    public function fillMapParams(){
        $map = $this->_map;

        $map->setAsync(false);
        $map->setAutoZoom(false);

        $marker = new Marker();
        $marker->setPosition($this->latitude, $this->longitude, true);
        $map->addMarker($marker);

        $map->setCenter($this->latitude, $this->longitude, true);
        $map->setMapOption('zoom', 5);

        $map->setBound(-2.1, -3.9, 2.6, 1.4, true, true);

        $map->setMapOption('mapTypeId', MapTypeId::ROADMAP);
        $map->setMapOption('mapTypeId', 'roadmap');

        $map->setMapOption('disableDefaultUI', true);
        $map->setMapOption('disableDoubleClickZoom', true);
        $map->setMapOptions(array(
            'disableDefaultUI'       => true,
            'disableDoubleClickZoom' => true,
        ));

        $map->setStylesheetOption('width', '500px');
        $map->setStylesheetOption('height', '500px');
        $map->setStylesheetOptions(array(
            'width'  => '500px',
            'height' => '500px',
        ));

        $map->setLanguage('en');
        $map->setLibraries(['places']);

        $view = $this->getView();
        $view->registerJS('
            var map = "'.$this->_map->getJavascriptVariable().'";
        ', View::POS_HEAD);

        $this->_map = $map;
        return $this->_map;
    }
} 