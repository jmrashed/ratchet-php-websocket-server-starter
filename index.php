<?php 
    session_start();
?>
<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <title>Live Chatting!</title>
</head>

<body>
    <div class="container">
        <div class="row mt-4">
            <div class="col-lg-3">
                <ul class="list-group" id="load_all_users">
                    <li class="list-group-item">
                        <a href="#53" data-id="53" class="menu">53</a>
                    </li>
                    <li class="list-group-item">
                        <a href="#84" data-id="54" class="menu">54</a>
                    </li>
                </ul>

            </div>
            <div class="col-lg-9">
                <?php 
                if(isset($_SERVER['resourceId'])) echo $_SERVER['resourceId'];
                print_r($_SESSION);
                if(isset( $_SESSION["userId"])){
                    echo 'Welcome '.  $_SESSION["userId"] ;
                }
                ?>
                <form action="#" class="form-horizontal">
                    <h3>Hello 53</h3>
                    <div class="form-group mb-3">
                        <input type="text" id="message" autocomplete="off" class="message form-control" value="testing ..." />

                    </div>
                    <div class="form-group">
                        <button onclick="transmitMessage()" class="btn btn-success">Send</button>
                    </div>

                </form>

            </div>
        </div>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
        crossorigin="anonymous"></script>
        <script
  src="https://code.jquery.com/jquery-3.6.1.min.js"
  integrity="sha256-o88AwQnZB+VDvE9tvIXrMQaPlFFSUTR+nldQm1LuPXQ="
  crossorigin="anonymous"></script>

    <script>
        // Create a new WebSocket.
        var socket = new WebSocket('ws://localhost:8080');
        console.log(socket);

        // Define the 
        var message = document.getElementById('message');

        function transmitMessage() {
            socket.send(message.value);
        }

        socket.onmessage = function (e) {
        $.get("session.php", function(data, status){
            console.log('called session file ... ');
            console.log(data);
            console.log(status);
        });
            alert(e.data);
        }


        $(function(){

            $.get("api/users.php", function(data, status){
                let users = jQuery.parseJSON( data);

                $('#load_all_users').empty();
                let list = ``;
                $.each( users, function( key, value ) {
                    list +=`
                    
                    <li class="list-group-item">
                        <a href="#${value['user_id']}" data-id="${value['user_id']}" data-email="${value['user_email']}"  class="menu">${value['user_name']}</a>
                    </li>
                    `;
                });
                $('#load_all_users').html(list);
            });
        });


    </script>
</body>
</body>

</html>