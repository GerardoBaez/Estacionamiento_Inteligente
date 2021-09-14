# Estacionamiento_Inteligente
 Proyecto Final Seguridad en IOT
 
 
 ![Image text](https://github.com/GerardoBaez/Estacionamiento_Inteligente/blob/main/logo.png?raw=true)

## Contenido
1. [Objetivo del proyecto](#Objetivo_del_Proyecto)
2. [Informacion General](#Informacion_General)
3. [Tecnologias](#Tecnologias)
4. [Hardware](#Hardware)
5. [Demo](#Demo)

## Objetivo del proyecto

Diseñar un prototipo por medio de tecnologías IoT, una base de datos NoSQL y un
dashboard para mostrar el total de autos que han entrado al estacionamiento y mostrar que
espacios están disponibles.

## Información General
La placa Nodemcu registra los cambios de estado de los 2 componentes conectados a ella(Sensor Pir,Dipswitch) actualiza el documento correspondiente
en la base de datos (ArangoDb) y al mismo tiempo manda un mensaje mediante el protocolo MQTT para actualizar el dashboard en el sitio web.

 
 ![Image text](https://github.com/GerardoBaez/Estacionamiento_Inteligente/blob/main/solucion.PNG?raw=true)

## Tecnologías
Tecnologias Usadas en el proyecto:
* ArangoDB :avocado:
* MQTT :mosquito:
* MySQL :floppy_disk:
* Google Authenticator :male_detective:
* HTML & CSS :paintbrush:
* PHP :hammer:

## Hardware
* Arduino
* Dipswitch de 4 Segmentos
* Sensor de movimiento PIR
* Servidor GNU/LINUX 2GB RAM 1CPU


## Demo

## Notas
Todo el credito de la auntenticacion de dos factores con Google  Authenticator  para el canal de youtube PuroCódigo: https://www.youtube.com/channel/UCiagAKd756q2I6c4V_K8SaA



