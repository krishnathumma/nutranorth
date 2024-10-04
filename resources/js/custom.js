
$('#npn_status').change(function(e) {
    var value = $("#npn_status").val();
    alert(value);
    if(value == "received"){
        $('#npn_number').prop("disabled", false);
        $('#npn_number').prop('required',true);
    } else {
        $('#npn_number').val('');
        $('#npn_number').prop("disabled", true);
    }
});
