#include <ESP8266WiFi.h>
#include <ESP8266HTTPClient.h>
#include "DHTesp.h"

#define HOST "iot.dominiodemiranda.playit.gg:33396" //HOST URL

#define WIFI_SSID "Tony"                 // WIFI SSID                                   
#define WIFI_PASSWORD "patosJariosos"    // WIFI password here

#define DHTpin 14

// Variables which will be uploaded to server

//int val1 = 1;
//int val2 = 99;
float val1 = 0;
float val2 = 0;
String sendval, sendval2, postData;

DHTesp dht;                                       //Initialize DHT Sensor

void setup(){
  Serial.begin(115200);                             // Information transfer rate from Arduino Code to NodeMCU
  Serial.println("Communication Started \n\n");  
  delay(2000);

  dht.setup(DHTpin, DHTesp::DHT11); // GPIO14
  
  pinMode(LED_BUILTIN, OUTPUT);                     // Initialize NodeMCU LED
 
  WiFi.mode(WIFI_STA);           
  WiFi.begin(WIFI_SSID, WIFI_PASSWORD);             // Try to connect with WiFi

  Serial.print("Connecting to ");
  Serial.print(WIFI_SSID);
  
  while (WiFi.status() != WL_CONNECTED){ 
    Serial.print(".");
    delay(500);
  }

  Serial.println();
  Serial.print("Connected to: ");
  Serial.println(WIFI_SSID);
  Serial.print("IP Address is: ");
  Serial.println(WiFi.localIP());                   // Print local IP address

  delay(500);
}

void loop() { 
 
  HTTPClient http;                                  // Http object of clas HTTPClient
  WiFiClient wclient;                               // Wclient object of clas HTTPClient
  
  val1 = dht.getTemperature();                   // Gets the values of the temperature
  val2 = dht.getHumidity();                // Gets the values of the humidity
  
  if(isnan(val1) || isnan(val2)){
    Serial.println("Error reading values from DHT Sensor");
    Serial.println("Sending 0's to Table");
    sendval = String(0);  
    sendval2 = String(0);
  }
  else{
    // Convert float variables to string
    sendval = String(val1);
    sendval2 = String(val2);
  }
  delay(180000);
// We can post values to PHP files as  example.com/dbwrite.php?name1=val1&name2=val2&name3=val3
  postData = "sendval=" + sendval + "&sendval2=" + sendval2;
  http.begin(wclient, "http://iot.dominiodemiranda.playit.gg:33396/dbwrite.php");   // Connect to host where dbwrite is located (PHP File to Write into SQL Database)
  http.addHeader("Content-Type", "application/x-www-form-urlencoded");            // Specify content-type header

  int httpCode = http.POST(postData);                                             // Send POST request to php file and store server response code in variable named httpCode
  Serial.println("Values sent were: Temperature = " + sendval + " && Humidity = "+sendval2 );


// If connection stablished successfully to database
  if (httpCode == 200){
    Serial.println("Values uploaded successfully.");
  }

// If failed to stablish then return and restart
  else { 
    Serial.println(httpCode);
    Serial.println("Failed to upload values. \n"); 
    http.end();
    return;
    }
  
  delay(2000); 
  digitalWrite(LED_BUILTIN, LOW);
  delay(2000);
  digitalWrite(LED_BUILTIN, HIGH);

//val+=1; val2+=10; // Incrementing value of variables
}
