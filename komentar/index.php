<?php
$host = "localhost";
$user = "root";
$password = "";
$db = "comentar";
$koneksi = mysqli_connect($host, $user, $password, $db);

if (!$koneksi) {
    die("Koneksi gagal:" . mysqli_connect_error());
}

if (isset($_POST['pinkomentar'])) {
    $nama = $_POST['nama-komentar'];
    $komentar = $_POST['komentar'];

    // Menggunakan fungsi NOW() untuk menambahkan waktu saat ini
    $sql = "INSERT INTO comments (name, message, created_at) VALUES ('$nama', '$komentar', NOW())";

    if (mysqli_query($koneksi, $sql)) {
        echo "komentar telah di post";
        header("location:index.php");
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($koneksi);
    }
}

if (isset($_GET['delete_id'])) {
    $idToDelete = $_GET['delete_id'];
    $deleteQuery = "DELETE FROM comments WHERE id = '$idToDelete'";
    $deleteResult = mysqli_query($koneksi, $deleteQuery);

    if ($deleteResult) {
        header("location: index.php?success=Komentar berhasil dihapus");
        exit;
    } else {
        echo "Deletion failed: " . mysqli_error($koneksi);
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Komentar for XI Oracle</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <!-- Font Awesome CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>
<nav class="navbar navbar-expand-sm navbar-dark">
    <img src="https://i.imgur.com/CFpa3nK.jpg" width="20" height="20" class="d-inline-block align-top rounded-circle" alt="">
    <a class="navbar-brand ml-2" href="#" data-abc="true">XI Oracle</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarColor02" aria-controls="navbarColor02" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="end">
        <div class="collapse navbar-collapse" id="navbarColor02">
            <ul class="navbar-nav">
                <li class="nav-item"> <a class="nav-link" href="#" data-abc="true">My class</a> </li>
                <li class="nav-item"> <a class="nav-link" href="#" data-abc="true">Gallery</a> </li>
                <li class="nav-item active"> <a class="nav-link mt-2" href="#" data-abc="true" id="clicked">Info<span class="sr-only">(current)</span></a> </li>
            </ul>
        </div>
    </div>
</nav>
<!-- Main Body -->
<section>
    <div class="container">
        <div class="row">
            <div class="col-sm-5 col-md-6 col-12 pb-4">
                <h1>Comments</h1>
                <?php
                $conn = new mysqli("localhost", "root", "", "comentar");

                if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error);
                }

                $result = $conn->query("SELECT * FROM comments");
                while ($tampil = $result->fetch_assoc()) {
                ?>
                    <div class="comment mt-4 text-justify float-left">
                        <div class="comment-header d-flex justify-content-between align-items-center">
                            <div>
                                <img src="https://i.imgur.com/yTFUilP.jpg" alt="" class="rounded-circle" width="40" height="40">
                                <h4><?php echo $tampil['name']; ?></h4>
                                <span>- <?php echo date('d F Y', strtotime($tampil['created_at'])); ?></span>
                            </div>
                            <a href="?delete_id=<?php echo $tampil['id']; ?>" class="btn btn-danger btn-sm">X</a>
                        </div>
                        <p><?php echo $tampil['message']; ?></p>
                    </div>
                <?php
                }
                $conn->close();
                ?>
            </div>
            <div class="col-lg-4 col-md-5 col-sm-4 offset-md-1 offset-sm-1 col-12 mt-4">
                <form id="align-form" method="post" action="">
                    <div class="form-group">
                        <h4>Berikan kami komentar</h4>
                        <label for="message">Message</label>
                        <textarea name="komentar" id="komentar" cols="30" rows="5" class="form-control" style="background-color: black;"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="name">Nama</label>
                        <input type="text" name="nama-komentar" id="nama-komentar" class="form-control">
                    </div>
                    <div class="form-group">
                        <button type="submit" id="pinkomentar" name="pinkomentar" class="btn">Post Komentar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function deleteComment(commentId) {
            alert('Implementasi penghapusan komentar untuk komentar dengan ID ' + commentId);
        }
    </script>
</section>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.bundle.min.js"></script>

	<style>
		.navbar-nav{
    width: 100%;
}

@media(min-width:568px){
    .end{
        margin-left: auto;
    }
}

@media(max-width:768px){
    #post{
        width: 100%;
    }
}
#clicked{
    padding-top: 1px;
    padding-bottom: 1px;
    text-align: center;
    width: 100%;
    background-color: #ecb21f;
    border-color: #a88734 #9c7e31 #846a29;
    color: black;
    border-width: 1px;
    border-style: solid;
    border-radius: 13px; 
}

#profile{
    background-color: unset;
    
} 

#post{
    margin: 10px;
    padding: 6px;
    padding-top: 2px;
    padding-bottom: 2px;
    text-align: center;
    background-color: #ecb21f;
    border-color: #a88734 #9c7e31 #846a29;
    color: black;
    border-width: 1px;
    border-style: solid;
    border-radius: 13px;
    width: 50%;
}

body{
    background-color: black;
}

#nav-items li a,#profile{
    text-decoration: none;
    color: rgb(224, 219, 219);
    background-color: black;
}


.comments{
    margin-top: 5%;
    margin-left: 20px;
}

.darker{
    border: 1px solid #ecb21f;
    background-color: black;
    float: right;
    border-radius: 5px;
    padding-left: 40px;
    padding-right: 30px;
    padding-top: 10px;
}

.comment{
    border: 1px solid rgba(16, 46, 46, 1);
    background-color: rgba(16, 46, 46, 0.973);
    float: left;
    border-radius: 5px;
    padding-left: 40px;
    padding-right: 30px;
    padding-top: 10px;
    
}
.comment h4,.comment span,.darker h4,.darker span{
    display: inline;
}

.comment p,.comment span,.darker p,.darker span{
    color: rgb(184, 183, 183);
}

h1,h4{
    color: white;
    font-weight: bold;
}
label{
    color: rgb(212, 208, 208);
}

#align-form{
    margin-top: 20px;
}
.form-group p a{
    color: white;
}

#checkbx{
    background-color: black;
}

#darker img{
    margin-right: 15px;
    position: static;
}

.form-group input,.form-group textarea{
    background-color: black;
    border: 1px solid rgba(16, 46, 46, 1);
    border-radius: 12px;
}

form{
    border: 1px solid rgba(16, 46, 46, 1);
    background-color: rgba(16, 46, 46, 0.973);
    border-radius: 5px;
    padding: 20px;
 }
	</style>
</body>
</html>