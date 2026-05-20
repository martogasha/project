<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <!-- fontawesome cdn for icon -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.8.2/css/all.css" />
    <!-- main css file -->
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">

    <!-- form start -->
    <div class="my-form">
        <div class="form-title">
            <h1>Member Login</h1>
            @include('flash-message')
        </div>
        <!-- main form -->
        <form action="{{url('Login')}}" method="post">
            @csrf
            <div class="single-input">
                <span><i class="fas fa-user"></i></span>
                <input type="text" placeholder="Phone Number" name="phone">
            </div>
            <div class="single-input">
                <span><i class="fas fa-unlock"></i></span>
                <input type="password" placeholder="Password" name="password">
            </div>

            <div class="single-input submit-btn">
                <input type="submit" value="Login">
            </div>
        </form>

    </div>


</div>





</body>
<style>
    /*css file*/
    body{
        margin: 0px;
        padding: 0px;
        background: #333;
    }
    .container{
        width: 100%;
        height: 100vh;
        display: flex;
        justify-content: center;
        align-items: center;
    }
    .my-form{
        background: #fff;
        padding: 30px 50px;
        border-radius: 10px;
    }
    .form-title{
        text-align: center;
        margin-bottom: 30px;
    }
    .form-title h1{
        margin: 0px;
        color: #0cd6a8;
    }
    .single-input{
        width: 270px;
        border:1px solid #c1c1c1;
        display: flex;
        margin-bottom: 15px;
    }
    .single-input i{
        padding: 8px 16px;
        color: #0cd6a8;
    }
    .single-input input{
        border:0px solid #c1c1c1;
        width: 100%;
        outline: none;
        height: 30px;
        font-size: 18px;
    }
    .submit-btn{
        border:0px solid #c1c1c1;
        margin-top: 30px;

    }
    .submit-btn input{
        background: #0cd6a8;
        color: #fff;
        cursor: pointer;
    }
</style>
</html>
