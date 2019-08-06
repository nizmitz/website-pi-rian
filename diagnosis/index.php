<?php 
    session_start();

    include("core/functions.php");
    include("core/db_config.php");

    main_banner(); 

    if (isset($_POST['submit'])) {
       
        $username = $_POST['username'];
        $password = $_POST['password'];
        $password = md5($password);
        if (empty($username) OR empty($password)) {
           $error = 'all fields are required';
        }else{
            $query = $db->get_results("SELECT * FROM admin WHERE username = '$username' AND password = '$password' LIMIT 1");
            foreach ( $query as $result ) {
                $admin_username = $result->username;
                $admin_password = $result->password;
            }

            if ($username == $admin_username && $password == $admin_password) {
                $_SESSION['username'] = $admin_username;
            } else{
                $error = 'wrong login credentials';
            }
        }
    }
?>
<!DOCTYPE HTML>
<html>
<html lang="en">
<head>
    <!--[if IE]>
      <script src="//html5shiv.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="author" content="Aiyk Ekwe">
    <title>Malaria Diagnosis System</title> 
    <link href="css/main.css" rel="stylesheet" type="text/css"/>
    <link href="css/banner.css" rel="stylesheet" type="text/css"/>
    <link href="css/slider.css" rel="stylesheet" type="text/css"/>
</head>
<body>
    <div id="content-wrapper">
      <div id="rhs">
        <p><span>Apa itu Malaria?</span>
                Malaria adalah penyakit menular yang disebabkan plasmodium,yaitu mahluk hidup bersel satu yang termasuk ke dalam kelompok protozoa. Malaria di tularkan melalui gigitan nyamuk Anopheles betina yang mengandung plasmodium di dalamnya. Plasmodium yang terbawa melalui gigitan nyamuk akan hidup dan berkembang biak dalam sel darah merah manusia.penyakit ini menyerang semua kelompok umur baik laki-laki maupun perempuan.orang yang terkena malaria akan memiliki gejala seperti deman,menggigil,berkeringat, sakit kepala,mual atau muntah. Penderita yang menunjukan gejala klinis harus menjalani tes laboratorium untuk mengkonfirmasi status positif malarianya
            </p><br/>
            <p>
                <span>Apa yang menyebabkan?</span>
                Malaria disebabkan oleh parasit Plasmodium yang disebarkan oleh gigitan nyamuk Anopheles betina. Setelah gigitan nyamuk tersebut, parasit masuk ke dalam tubuh dan menempati organ hati, di mana parasit dapat tumbuh dan berkembang biak.

Saat parasit tersebut tumbuh dan menjadi dewasa, parasit pergi dari organ hati dan merusak sel darah merah. Kerusakan pada sel darah merah inilah yang menimbulkan gejala anemia pada penderita.
            </p><br/>
             <p><span>Kapan Harus Ke Dokter?</span>
              Seperti yang telah Anda ketahui sebelumnya, bahwa malaria bisa berkembang dalam waktu yang sangat cepat. Sebaiknya, jika Anda atau anggota keluarga mengalami tanda-tanda penyakit seperti yang disebutkan di atas, segera cari bantuan perawatan medis secepat mungkin.

Terlebih jika gejala tersebut muncul pada bayi, anak kecil, dan ibu hamil sebab gejala malaria akan berkembang menjadi sangat parah pada ketiga kelompok tersebut.

Tak terkecuali bagi Anda yang tinggal di daerah dengan kasus malaria yang rendah, namun telah melakukan perjalanan dari daerah yang berisiko malaria.

Jika sepulang dari daerah tersebut Anda mengalami demam tinggi, meskipun melakukan pencegahan malaria serta rutin mengonsumsi obat antimalaria, Anda harus tetap memeriksakan diri ke dokter.
</p>
      </div>
      <div id="lhs">
        <a id="a-home" class="top-link hide" href="index.php">HOME</a>
        <?php 
            if (isset($_SESSION['username'])) { 
                $logedin_user = $_SESSION['username'];
                echo'
                    <nav id="nav_links">
                        <ul>
                            <li id="view-symptom">Daftar Gejala</li> 
                            <li id="add-symptom">Tambah Gejala</li>
                        </ul>
                    </nav> 
                    <p id="logedin_user">Hello '.$logedin_user.'<a href="signout.php">SIGN OUT</a></p>
                    ';
            } else{
                echo'<span id="span-signin" class="top-link">ADMIN</span>';
            }
        ?>
        <div id="div-signin" class="hide mid">
          <?php
            if (isset($error)) {
              echo '<div class="error">'.$error.'</div>';
            }
            if (isset($success)) {
              echo '<div class="error">'.$success.'</div>';
            }
          ?>
            <form id="frm-signin" class="frm" method="post" action="index.php">
                <h3>Admin Sign In</h3>
                <label for="username">Username:</label>
                <input type="text" class="input" id="username" name="username" maxlength="20"/><br/>
                <label for="password">Password:</label>
                <input type="password" class="input" id="password" name="password" maxlength="20"/><br/>
                <input type="submit" name="submit" id="submit" class= "my_button" value="Sign In"/>
            </form>
        </div>
        <div id="div-add-symptom" class="hide mid">
            <h3>Tambahkan Gejala Malaria</h3><br/>
            <form id="frm-add-symptom" class="frm" method="post" action="">
                <input type="text" class="input" id="txt-symptom" name="txt-symptom"/>
                <input type="button" name="submit-symptom" id="submit-symptom" value="Submit"/>
            </form>
        </div>
        <div id="div-view-symptoms" class="hide"><h3>Added Maleria Symptoms</h3><br/><ul id="ul-view-symptoms"></ul></div>
        <div id="cta">Mulai Diagnosa</div>
        <div id="symptoms-wrapper" style="display: none;">
          <ul id="ul-symptoms">
          </ul>
          <div id="choice-wrapper">
              <div id="yes" class="btn-choice">YES</div>
              <div id="no" class="btn-choice">NO</div>
              <span class="fake"></span>
          </div>
          <hr/>
          <div id="controls-wrapper">
              <span id="next" class="my_button">NEXT</span>
          </div>
        </div>
        <span id="btn-result" class="hide my_button">RESULT</span>
        <div id="div-result" class="hide"><p id="p-result"></p><a href="index.php" class="my_button">REFRESH</a></div>
      </div>
      <div class="fake"></div>
    </div>
    <script type="text/javascript" src="js/jquery-1.11.2.min.js"></script>
    <script src="js/responsiveslides.min.js"></script>
    <script type="text/javascript" src="js/slider.js"></script>
    <script type="text/javascript" src="js/ajax.js"></script>

    <script>
      $(".rslides").responsiveSlides({
          speed: 2000,            // Integer: Speed of the transition, in milliseconds
          timeout: 3000,          // Integer: Time between slide transitions, in milliseconds
          before: function(){},   // Function: Before callback
          after: function(){}     // Function: After callback
        });
    </script>
    
</body>
</html> 
    