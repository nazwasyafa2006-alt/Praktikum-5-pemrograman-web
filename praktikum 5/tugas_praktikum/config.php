<?php
$conn = mysqli_connect("localhost","root","","greendayeuh2");

if(!$conn){
    die("Koneksi gagal: " . mysqli_connect_error());
}
?>