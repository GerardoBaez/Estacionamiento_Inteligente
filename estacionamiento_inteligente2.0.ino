
//------------------------LIBRERIAS--------------------------------------------------------------------
#include <ESP8266WiFi.h>
#include <PubSubClient.h>
#include <WiFiClientSecure.h> 
#include <ArduinoJson.h>
#include <ESP8266HTTPClient.h>
#include <WiFiClient.h>
#include <ESP8266WebServer.h>
#include <ESP8266HTTPClient.h>

//------------------------DATOS--------------------------------------------------------------------
#define DIP1 D1 // PINES DE NODEMCU
#define DIP2 D2
#define DIP3 D3
#define DIP4 D4
#define PIR_Sensor D0                     // PIR sensor 
int Waiting_Time = 5000;                  
const int LED = 2; //GPIO 2 corresponde al LED integrado de las placas NodeMCU - Wemos D1  
int autos=0;
int ant=0;
int espac1ant=0;


String server = "http://138.68.163.65:8529/_db/_system/Estacionamiento/autos/viernes";// CAMBIAR KEY DEL DOCUMENTO A ACTUALIZAR
String server_espacio1 = "http://138.68.163.65:8529/_db/_system/Estacionamiento/espacios/espacio1";
String server_espacio2 = "http://138.68.163.65:8529/_db/_system/Estacionamiento/espacios/espacio2";



//----------------------CONEXION WIFI-------------------------------------------------

const char* ssid = "INFINITUM5422_2.4";
const char* password = ""; //contraseña red
const char* mqttServer = "www.equipo1.tech";
const int mqttPort = 1884; //puerto mqtt
const char* mqttUser = "gerardo"; // usuario mqtt
const char* mqttPassword = ""; //contraseña mqtt



//-------GLOBALES-------------------

WiFiClient espClient;
PubSubClient client(espClient);
long lastMsg = 0;
char msg[50];
int value = 0;

//-------------------------------------------FUNCIONES---------------------------------------------------------------------------------------------------------

void setup() {
  pinMode(PIR_Sensor, INPUT); // SENSOR
  pinMode(LED, OUTPUT);     // Initialize the BUILTIN_LED pin as an output
  pinMode(DIP1,INPUT_PULLUP); // Dipswitch1
  pinMode(DIP2,INPUT_PULLUP); // Dipswitch2
  digitalWrite(LED, HIGH); 
  Serial.begin(115200);
  setup_wifi();
  mqtt();

}


void mqtt(){
   
  client.setServer(mqttServer, mqttPort);
  while (!client.connected()) {
    Serial.println("Connecting to MQTT...");
 
    if (client.connect("www.equipo1.tech", mqttUser, mqttPassword )) {
 
      Serial.println("connected");  
 
    } else {
 
      Serial.print("failed with state ");
      Serial.print(client.state());
      delay(2000);
 
    }
  }
  
  
  
  
  
  }



void setup_wifi() {

  delay(10);
  // We start by connecting to a WiFi network
  Serial.println();
  Serial.print("Connecting to ");
  Serial.println(ssid);

  WiFi.begin(ssid, password);

  while (WiFi.status() != WL_CONNECTED) {
    delay(500);
    Serial.print(".");
  }

  Serial.println("");
  Serial.println("WiFi connected");
  Serial.println("IP address: ");
  Serial.println(WiFi.localIP());
}

void loop() {
  mqtt();
  int state = digitalRead(PIR_Sensor);    // Continuously check the state of PIR sensor
  delay(250);                             // Check state of PIR after every half second
    if(state == HIGH){                
      digitalWrite (LED, LOW);    // Enciende  el led
      delay(150);                
      autos=autos+1;   // incrementa la variable autos                       
    }
    else {
      digitalWrite (LED, HIGH);      // Apaga el led
      ant=autos;
   }
  
  Serial.println("Detector de autos: ");
  Serial.println(state);
  Serial.print("Autos en el estacionamiento: ");
  Serial.println(autos);

  if(ant!=autos){
    
    /*String str = "Total de autos en el estacionamiento -> " + String(autos);*/
    String str= String(autos);
    str.toCharArray(msg,50);
    delay(150);
    post(String(autos));
    client.publish("autos", msg);
    
    }

    if (autos>=12)
    {
      autos=0;
      String str= String(autos);
      str.toCharArray(msg,50);
      post(String(autos));
      client.publish("autos", msg);
      delay(150);
      
      
      
      
    }
    
  espacios();
  client.loop();

 
}


/**************************************
//*********** PATCH Autos  ********************
***************************************/


void post(String autos) {
  HTTPClient http;

  String json;
  StaticJsonBuffer<200> jsonBuffer;
  JsonObject& root = jsonBuffer.createObject();
  root["_total"] = autos;
  /* Ejemplo si quieres más atributos
  root["sensor"] = "gps";
  root["time"] = 1351824120;*/
  root.printTo(json);
  
  Serial.println(""); // salto de linea para http.writeToStream(&Serial);
  
  http.begin(server); //URL del microservicio
  http.addHeader("Content-Type", "application/json");
  http.PATCH(json); 
  http.writeToStream(&Serial);
  http.end();
  delay(1000);
}

/**************************************
//*********** Espacios  ********************
***************************************/

void espacios() {
  // put your main code here, to run repeatedly:

  if(digitalRead(DIP1))
  {
      Serial.print("ENCENDIDO PIN 1 ");
      Serial.println();
      Serial.print("Ocupado estacionamiento 1 ");
      Serial.println();
      String espac1 = "Ocupado  espacio 1 ";
      espac1.toCharArray(msg,50);
      postespac1(espac1);
      Serial.println("Publicando MQTT esp1 ocupado...");
      client.publish("esp1", "2");
      delay(3000);
      
    
  }
  else
  {
     Serial.print("APAGADO PIN 1 ");
     Serial.println();
     Serial.print("Desocupado estacionamiento 1 ");
     Serial.println();
     String espac1 = "Desocupado  espacio 1 ";
     espac1.toCharArray(msg,50);
     postespac1(espac1);
     Serial.println("Publicando MQTT esp1 desocupado...");
     client.publish("esp1", "1");
     delay(3000);
   
  }

/*DIP2*/

 if(digitalRead(DIP2))
  {
      Serial.print("ENCENDIDO PIN 2 ");
      Serial.println();
      Serial.print("Ocupado estacionamiento 2 ");
      Serial.println();
      String espac2 = "Ocupado espacio 2 ";
      espac2.toCharArray(msg,50);
      postespac2(espac2);
      Serial.println("Publicando MQTT esp2 ocupado...");
      client.publish("esp2", "2");
      delay(3000);

    
  }
  else
  {
     Serial.print("APAGADO PIN 2 ");
     Serial.println();
     Serial.print("Desocupado estacionamiento 2 ");
     Serial.println();
     String espac2 = "Desocupado espacio 2 ";
     espac2.toCharArray(msg,50);
     postespac2(espac2);
     Serial.println("Publicando MQTT esp2 desocupado...");
     client.publish("esp2", "1");
     delay(3000);
   
  }

}



/**************************************
//*********** PATCH Espacios  ********************
***************************************/


void postespac1(String espac1 ) {
  HTTPClient http;

  String json;
  StaticJsonBuffer<200> jsonBuffer;
  JsonObject& root = jsonBuffer.createObject();
  root["status"] = espac1;
  /* Ejemplo si quieres más atributos
  root["sensor"] = "gps";
  root["time"] = 1351824120;*/
  root.printTo(json);
  
  Serial.println(""); // salto de linea para http.writeToStream(&Serial);
  
  http.begin(server_espacio1); //URL del microservicio
  http.addHeader("Content-Type", "application/json");
  http.PATCH(json); 
  http.writeToStream(&Serial);
  http.end();
  delay(1000);
}





void postespac2(String espac2 ) {
  HTTPClient http;

  String json;
  StaticJsonBuffer<200> jsonBuffer;
  JsonObject& root = jsonBuffer.createObject();
  root["status"] = espac2;
  /* Ejemplo si quieres más atributos
  root["sensor"] = "gps";
  root["time"] = 1351824120;*/
  root.printTo(json);
  
  Serial.println(""); // salto de linea para http.writeToStream(&Serial);
  
  http.begin(server_espacio2); //URL del microservicio
  http.addHeader("Content-Type", "application/json");
  http.PATCH(json); 
  http.writeToStream(&Serial);
  http.end();
  delay(1000);
}
