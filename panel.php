<?php

  include './templates/header.php';
  
  if (!$userController->isUserLoggedIn()) {
    header('Location: login.php');
  }

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
     <meta charset="UTF-8">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/paho-mqtt/1.0.1/mqttws31.js" type="text/javascript"></script>
    <script src="//cdn.rawgit.com/Mikhus/canvas-gauges/gh-pages/download/2.1.7/all/gauge.min.js"></script>
    <!--<script src='mqttws31.js' type='text/javascript'></script> -->
    <!-- https://api.cloudmqtt.com/sso/js/mqttws31.js -->  
</head>
<body bgcolor="E8DAEF">

    <?php include './templates/nav.php' ?>

    <div class="container mt-5">        
        <h3>Panel de usuario</h3><hr />
    </div>

    <center>
      <h1><img src="estrella.gif" width="3%"><font face="Comic Sans MS,Arial,Verdana"> Estacionamiento Inteligente </font><img src="estrella.gif" width="3%"></h1>
      <!---<table border="0" width="40%" bgcolor="D2B4DE">
        <tr>
          <td width="60%"><h2><font face="Comic Sans MS,Arial,Verdana">Suscripciones:</font></h2></td>
          <td width="40%"><h2><font face="Comic Sans MS,Arial,Verdana">Publicaciones:</font></h2></td>
        </tr>
        <tr>
          <td>
            <a>Temperatura: </a>
            <a id ="temperatura">-</a>
            <br>
            <a>Pulsador: </a>
            <a id ="pulsador">-</a>
          </td>
          <td>
            <a>Entrada: </a>
            <button type='button' onclick='OnOff("Abierta")'>
              <img src="on.png" width="30px" height="30px">
            </button>
            <button type='button' onclick='OnOff("Cerrada")'>
              <img src="off.png" width="30px" height="30px">
            </button>
          </td>
        </tr>
      </table>--->

      <!--<div>
        <h2><font face="Comic Sans MS,Arial,Verdana">Suscripciones:</font></h2>
        <a>Temperatura: </a>
        <a id ="temperatura">-</a>
        <br>
        <a>Pulsador: </a>
        <a id ="pulsador">-</a>
      </div>

      <div>
        <h2><font face="Comic Sans MS,Arial,Verdana">Publicaciones:</font></h2>
        <a>Entrada: </a>
        <button type='button' onclick='OnOff("Abierta")'>ON</button>
        <button type='button' onclick='OnOff("Cerrada")'>OFF</button>
      </div>
      -->

      <div>
      <h2><font face="Comic Sans MS,Arial,Verdana">Contador de autos</font></h2>
      <canvas data-type="linear-gauge" id="autos"
                      data-width="400"
                      data-height="150"
                      data-min-value="0"
                      data-max-value="12"
                      data-major-ticks="0,5,10,12"
                      data-minor-ticks="2"
                      data-stroke-ticks="true"
                      data-highlights='false'
                      data-color-plate="#fff"
                      data-border-shadow-width="0"
                      data-borders="false"
                      data-bar-begin-circle="false"
                      data-bar-width="10"
                      data-tick-side="left"
                      data-number-side="left"
                      data-needle-side="left"
                      data-needle-type="line"
                      data-needle-width="3"
                      data-color-needle="#222"
                      data-color-needle-end="#222"
                      data-animation-duration="1500"
                      data-animation-rule="linear"
                      data-animation-target="plate"
              ></canvas>
            
      </div >

      <div>
        <h2><font face="Comic Sans MS,Arial,Verdana">Nivel 1</font></h2>
        <img src="1.png" style="width:200px;height:300px;" id="esp1">
        <img src="1.png" style="width:200px;height:300px;" id="esp2">
        <img src="1.png" style="width:200px;height:300px;" id="esp3">
        <img src="1.png" style="width:200px;height:300px;" id="esp4">
      </div>

      <div>
        <h2><font face="Comic Sans MS,Arial,Verdana">Nivel 2</font></h2>
        <img src="1.png" style="width:200px;height:300px;" id="esp5">
        <img src="1.png" style="width:200px;height:300px;" id="esp6">
        <img src="1.png" style="width:200px;height:300px;" id="esp7">
        <img src="1.png" style="width:200px;height:300px;" id="esp8">
      </div>

      <div>
        <h2><font face="Comic Sans MS,Arial,Verdana">Nivel 3</font></h2>
        <img src="1.png" style="width:200px;height:300px;" id="esp9">
        <img src="1.png" style="width:200px;height:300px;" id="esp10">
        <img src="1.png" style="width:200px;height:300px;" id="esp11">
        <img src="1.png" style="width:200px;height:300px;" id="esp12">
      </div>
    <br>
    <a href="index.php">Inicio</a>
    <a href="https://www.equipo1.tech/">Nosotros</a>
    <p>Copyright 2021 Mandanos un mensaje vía email a <a>superchampions@gmail.com</a></p>

    <script>  
      //Usuario y contraseña dado de alta en mosquitto    
      usuario = 'gerardo';
      contrasena = 'asd12asd12';
      

      //Funciones para publicar
      function OnOff(dato){
        message = new Paho.MQTT.Message(dato);
        message.destinationName = 'entrada'
        client.send(message);
      };
       
      // called when the client connects
      function onConnect() {
        // Once a connection has been made, make a subscription and send a message.
        console.log("onConnect");
        client.subscribe("#");
      }
        
      // called when the client loses its connection
      function onConnectionLost(responseObject) {
        if (responseObject.errorCode !== 0) {
          console.log("onConnectionLost:", responseObject.errorMessage);
          setTimeout(function() { client.connect() }, 5000);
        }
      }
        
      // called when a message arrives
      function onMessageArrived(message) {
        if (message.destinationName == 'esp1') { //acá coloco el topic
            document.getElementById("esp1").setAttribute("src", message.payloadString+".png");
        }
        if (message.destinationName == 'esp2') { //acá coloco el topic
            document.getElementById("esp2").setAttribute("src", message.payloadString+".png");
        }
        if (message.destinationName == 'esp3') { //acá coloco el topic
            document.getElementById("esp3").setAttribute("src", message.payloadString+".png");
        }
        if (message.destinationName == 'esp4') { //acá coloco el topic
            document.getElementById("esp4").setAttribute("src", message.payloadString+".png");
        }
        if (message.destinationName == 'esp5') { //acá coloco el topic
            document.getElementById("esp5").setAttribute("src", message.payloadString+".png");
        }
        if (message.destinationName == 'esp6') { //acá coloco el topic
            document.getElementById("esp6").setAttribute("src", message.payloadString+".png");
        }
        if (message.destinationName == 'esp7') { //acá coloco el topic
            document.getElementById("esp7").setAttribute("src", message.payloadString+".png");
        }
        if (message.destinationName == 'esp8') { //acá coloco el topic
            document.getElementById("esp8").setAttribute("src", message.payloadString+".png");
        }
        if (message.destinationName == 'esp9') { //acá coloco el topic
            document.getElementById("esp9").setAttribute("src", message.payloadString+".png");
        }
        if (message.destinationName == 'esp10') { //acá coloco el topic
            document.getElementById("esp10").setAttribute("src", message.payloadString+".png");
        }
        if (message.destinationName == 'esp11') { //acá coloco el topic
            document.getElementById("esp11").setAttribute("src", message.payloadString+".png");
        }
        if (message.destinationName == 'esp12') { //acá coloco el topic
            document.getElementById("esp12").setAttribute("src", message.payloadString+".png");
        }

        if (message.destinationName == 'autos') { //acá coloco el topic
            document.getElementById("autos").setAttribute("data-value", message.payloadString);
            
        }
      }

        function onFailure(invocationContext, errorCode, errorMessage) {
          var errDiv = document.getElementById("error");
          errDiv.textContent = "Could not connect to WebSocket server, most likely you're behind a firewall that doesn't allow outgoing connections to port 39627";
          errDiv.style.display = "block";
        }
        
        var clientId = "ws" + Math.random();
        // Create a client instance, con la url del dominio configurado
        var client = new Paho.MQTT.Client("www.equipo1.tech", 8083, clientId);
        //var client = new Paho.MQTT.Client("wss://mqtt.eclipse.org", clientId);
        
        // set callback handlers
        client.onConnectionLost = onConnectionLost;
        client.onMessageArrived = onMessageArrived;
        
        // connect the client
        client.connect({
          useSSL: true,
          userName: usuario,
          password: contrasena,
          onSuccess: onConnect,
          onFailure: onFailure
        });        
    </script>
    </center>
    
</body>
</html>