

<!--HTML input with autocompletation -->

<input name="address" id="autocomplete" placeholder="Enter your address" type="text"></input>

<!--PHP code who give you lat and long with adress -->

<?php

function getLatLong($address){
    if(!empty($address)){
        //Format to web adressformat
        $formattedAddress = str_replace(' ','+',$address);
        //Send request and receive json data by address
        $geocodeFromAddress = file_get_contents('https://maps.googleapis.com/maps/api/geocode/json?address='.$formattedAddress.'&sensor=true_or_false&key= || YOUR API KEY ||');
        $output = json_decode($geocodeFromAddress);
        //Get latitude and longitute from json data
        $data['latitude']  = $output->results[0]->geometry->location->lat;
        $data['longitude'] = $output->results[0]->geometry->location->lng;
        //Return latitude and longitude of the given address
        if(!empty($data)){
            return $data;
        }else{
            return false;
        }
    }else{
        return false;
    }
}

$latLong = getLatLong($address);

// Extract lat, if nothing was found, 'Not found' given
$latitude = $latLong['latitude']?$latLong['latitude']:'Not found';

// Extract long, if nothing was found, 'Not found' given
$longitude = $latLong['longitude']?$latLong['longitude']:'Not found';

?>

<!--Javascript part for autocompletation-->

<script>
    var placeSearch, autocomplete;

    function initAutocomplete() {
        // Create the autocomplete object, restricting the search to geographical
        // location types.
        autocomplete = new google.maps.places.Autocomplete(
            /** @type {!HTMLInputElement} */(document.getElementById('autocomplete')),
            {types: ['geocode']});

        // When the user selects an address from the dropdown, populate the address
        // fields in the form.
        autocomplete.addListener('place_changed', fillInAddress);
    }
</script>

<!-- Script Include -->
<script src="https://maps.googleapis.com/maps/api/js?key= || YOUR API KEY ||&libraries=places&callback=initAutocomplete"
        async defer></script>



