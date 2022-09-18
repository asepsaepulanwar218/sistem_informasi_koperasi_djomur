$(document).ready(function() {

    $("#keyword").hide();

    $("#search").on('keyup',function() {
        console.log($('#search').val());
        $("#konten").load('anggotaSearch.php?search=' + $('#search').val());
    });
        
    
});

