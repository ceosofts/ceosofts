function select_name() {
    // alert("Hello World");
    var x = document.getElementById("cus_contact").value;
    $ajax({
        url: "showcusname.php",
        method: "POST",
        data:{
            id : x

        },
        success: function(data) {
            $("#ans").html(data);
        }
    })
}