
/* Redes Móveis e Sem Fios (RMSF)
 * Projecto desenvolvido por 
 *  CARINA FERNANDES 84019
 *  SOPHIE TABOADA 84187
 */

#include <WiFi.h>
#include <HTTPClient.h>
#include <OneWire.h> 
#include <DallasTemperature.h>
#define ONE_WIRE_BUS 15
//#define SENSOR_RESOLUTION 12
OneWire oneWire(ONE_WIRE_BUS); 
DallasTemperature sensors(&oneWire);

HTTPClient http;
int i;
float temp;
int tempo;
int wb_on=0;
String tmin_aux="";
String tmax_aux="";
String wbstatus_aux="";
float tmin;
float tmax;
int wbstatus;

//DeviceAddress sensorDeviceAddress;
DeviceAddress sensor = { 0x28, 0xFE, 0x2, 0x45, 0x92, 0x5, 0x2, 0xb9 };

//Definição das constantes com o nome da rede e a password
const char* ssid = "iPhone Sophie T.";
const char* password = "22446688";
String username="";
 
void setup() {
  
 pinMode(19, OUTPUT); 
 digitalWrite(19,HIGH);
  // Inicia a comunicação em série na velocidade 115200
  Serial.begin(115200); 
  delay(10);
  Serial.println("Dallas Temperature IC Control Library Demo"); 
 // Start up the library 
  sensors.begin(); 

  // Connect to WiFi network
  Serial.println();
  Serial.println();
  Serial.print("Connecting to ");
  Serial.println(ssid);

  // Estabelece a ligação ao WiFi
  WiFi.begin(ssid, password);

  //Verifica se a conecção foi estabelecida
  while (WiFi.status() != WL_CONNECTED) {
    delay(500);
    Serial.print(".");
  }
  Serial.println("");
  Serial.println("WiFi connected");
}
 
void loop() {
  tmin_aux="";
  tmax_aux="";
  wb_on=0;
  username="";
  //String endWeb3 = "http://web.ist.utl.pt/~ist425319/name.php?";
  String endWeb3 = "http://web.ist.utl.pt/~ist425319/username.txt";
  http.begin(endWeb3);
  int httpCode3 = http.GET();    //Make the request
  if (httpCode3 > 0) { //Check for the returning code
          String payload0 = http.getString();
          i=1;
          while(payload0[i]!='"'){
              username= username + payload0[i];
              i++;
          }
          Serial.print("username:");
          Serial.println(username);
          
  }
  else {
          Serial.println("Error on HTTP request");
  }
    
      String endWeb1 = "http://web.ist.utl.pt/~ist425319/getvals.php?username=";
      endWeb1= endWeb1 + username;
      http.begin(endWeb1);
      int httpCode1 = http.GET();    //Make the request
      if (httpCode1 > 0) { //Check for the returning code
              String payload1 = http.getString();
              Serial.println(payload1);
              

              i=9;
              while(payload1[i]!='"'){
                tmin_aux=tmin_aux + payload1[i];
                i++;
              }
              tmin=tmin_aux.toFloat();
              i=i+10;
              while(payload1[i]!='"'){
                tmax_aux=tmax_aux + payload1[i];
                i++;
              }
              tmax=tmax_aux.toFloat();
              i=i+15;
              wbstatus_aux=payload1[i];
              wbstatus=wbstatus_aux.toInt();
             Serial.println("lido da mensagem");
             Serial.print("Tmin:");
             Serial.println(tmin);
             Serial.print("Tmax:");
             Serial.println(tmax);
             Serial.print("WB:");
             Serial.println(wbstatus);
      }
      else {
              Serial.println("Error on HTTP request");
      }


    sensors.requestTemperatures(); // Send the command to get temperature readings 
    delay(1000);
    Serial.print("Temperature in Celsius is: "); 
    temp=sensors.getTempC(sensor);
    Serial.println(temp); 
    
  // mudar aqui o hello por username e o temp=12 por + temp e + tempo tambem
  String endWeb2 = "http://web.ist.utl.pt/~ist425319/insertTc.php?username=";
  endWeb2=endWeb2 + username + "&temp=" + temp + "&time_s=" + millis();
  http.begin(endWeb2);

  int httpCode2 = http.GET();    //Make the request
  if (httpCode2 > 0) { //Check for the returning code
          String payload2 = http.getString();
          //Serial.println(httpCode);  // funciona sem essa linha
          Serial.println(payload2);
  }
  else {
          Serial.println("Error on HTTP request");
  }
  http.end(); //Free the resources

  if(wbstatus==1)
  {
    if(temp>tmax){
      Serial.println("Ligar Bomba");
      wb_on=1;
      digitalWrite(19, LOW);
    }else{
       Serial.println("Desligar Bomba");
       wb_on=0;
      digitalWrite(19, HIGH);
    }
  }else{
       wb_on=0;
      digitalWrite(19, HIGH);
  }

delay(5000);  // vai enviar o link a cada 5 segudos


 
}
