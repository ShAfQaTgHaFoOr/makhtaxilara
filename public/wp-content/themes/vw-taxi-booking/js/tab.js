function vw_taxi_booking_open_tab(evt, cityName) {
    var vw_taxi_booking_i, vw_taxi_booking_tabcontent, vw_taxi_booking_tablinks;
    vw_taxi_booking_tabcontent = document.getElementsByClassName("tabcontent");
    for (vw_taxi_booking_i = 0; vw_taxi_booking_i < vw_taxi_booking_tabcontent.length; vw_taxi_booking_i++) {
        vw_taxi_booking_tabcontent[vw_taxi_booking_i].style.display = "none";
    }
    vw_taxi_booking_tablinks = document.getElementsByClassName("tablinks");
    for (vw_taxi_booking_i = 0; vw_taxi_booking_i < vw_taxi_booking_tablinks.length; vw_taxi_booking_i++) {
        vw_taxi_booking_tablinks[vw_taxi_booking_i].className = vw_taxi_booking_tablinks[vw_taxi_booking_i].className.replace(" active", "");
    }
    document.getElementById(cityName).style.display = "block";
    evt.currentTarget.className += " active";
}

jQuery(document).ready(function () {
    jQuery( ".tab-sec .tablinks" ).first().addClass( "active" );
});