<?php

require 'koneksi.php';

if (reset_beli () > 0) {
    echo "<script>
            document.location.href = 'pengajuan_pembelian.php';
        </script>"; 
} else {
    echo "
    <script>
        document.location.href = 'pengajuan_pembelian.php';
    </script>
    ";  
}

function reset_beli() {
    global $conn;
    mysqli_query($conn, "DELETE from detail_beli where pembelian_id is null");

    return mysqli_affected_rows($conn);
}
