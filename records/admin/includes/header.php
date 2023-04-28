<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>KEBO Group | Home</title>

    <!-- Core Bootstrap Css -->
    <link rel="stylesheet" href="../assets/dist/css/bootstrap.min.css">

    <!-- Core MDB Css -->
    <link rel="stylesheet" href="../assets/md/css/mdb.min.css">

    <!-- Core MDB Css -->
    <link rel="stylesheet" href="../assets/md/css/style.css">

    <!-- Icon styles -->
    <link rel="stylesheet" href="../assets/icons/style.css">

    <!-- Icon styles -->
    <link rel="stylesheet" href="../../assets/style.min.css">

    <!-- Internal CSS -->
    <style type="text/css">
        .top{
            border-top-right-radius:5px;
            border-top-left-radius:5px;
        }
        .bottom{
            border-top: 5px solid white;
        }
        ul{
            list-style:none;
            margin-left: -40px;

        }
        ul li{
            float:left;
            width:110px;
            height:65px;
            line-height:65px;
            text-align: center;
        }
        ul li a{
            display:block;
            color:black;
            font-family:Century Gothic;
            transition: border 1s ease-in-out;
        }
        ul li a:hover{
        	border-bottom: 3px solid #A35448;  /*color : #A35448*/
        	color:#A35448;
        	font-weight: bold;
        }
        .active{
        	border-bottom: 3px solid #A35448;
        	color:#A35448;
        	font-weight: bold;
        }
        /* input[type="submit"]{
        	background-color: #A35448;
        	outline: none;
        	border:none;
        	height: 30px;
        	width: 80px;
        	text-align: center;
        	color:white;
        	border-radius: 5px;
        	margin-top: 10px;
        } */
        tr th{
            font-weight: bold;
            /* font-style: italic; */
        }
        .withdraw-modal{
            display: none;
        }
        .showup{
            display: block;
            animation: modalanim 1s cubic-bezier(0.165, 0.84, 0.44, 1) 0s 1 alternate forwards;
        }
        @keyframes modalanim{
            from{
                transform: translateY(200px);
            }
            to{
                transform: translateY(0px);
            }
        }
        .well1{
        background-color: #fff;
        /* width:240px;
        height:240px; */
        display:-webkit-box;
        display:-ms-flexbox;
        display:flex;
        -webkit-box-pack:center;
        -ms-flex-pack:center;
        justify-content:center;
        -webkit-box-align:center;
        -ms-flex-align:center;
        align-items:center;
        border-radius:5%}
        .well{
          border-radius:2%;
        }

</style>

</head>
<body style="background-color:#f8f5f5;">
    <br>
    <div class="container">
    	<div class="row">
    		<div class="col-md-12 teal p-3 top">
          <div class="row">
            <div class="col-md-11 teal-text text-center">
              <img src="../pictures/logo_k_home.svg" style="height: 70px; width: 420px; margin-top: -20px;">
            </div>
            <div class="col-md-1">
              <a href="index.php" title="Eplore Other Date"><span class="text-center text-white ml-3" data-icon="&#xe023;"></span></a>
            </div>
          </div>
        </div>
    	</div>
        <div class="row">
            <div class="col-lg-12">
                <div class="row">
                    <div class="col-md-2 teal p-2 bottom">
                        <h3 class="white-text text-center" style="font-family:Caviar Dreams; line-height:38px;">
                          <!-- <span style="font-size: 30px;font-weight: bold;" data-icon="&#xe074;" class="text-center white-text"></span> -->
                              <?php# echo $username; ?><img src="../pictures/logo_k_admin.svg" style="height: 38px; width: 68px;">
                                      </h3>
                    </div>
