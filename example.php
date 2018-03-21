<!-- SAMPLE code -->

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

if (isset($_POST["address"])) {
    $address=$_POST["address"];
    $latLong = getLatLong($address);
    $latitude = $latLong['latitude']?$latLong['latitude']:'Not found';
    $longitude = $latLong['longitude']?$latLong['longitude']:'Not found';
    echo $latitude . " ";
    echo $longitude;
}


?>

 <form action="" class="form" role="form" autocomplete="off" id="loginForm" method="POST">
    <div class="form-group">
        <input name="address" id="autocomplete" placeholder="Enter your address" type="text"></input>
    </div>
    <button type="submit" class="btn btn-success btn-lg float-right" id="btnLogin">Check things</button>
</form>


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

<script src="https://maps.googleapis.com/maps/api/js?key= || YOUR API KEY || &libraries=places&callback=initAutocomplete"
        async defer></script>
