#include <SPI.h>
#include <RF24.h>
#include <ESP8266WiFi.h>
#include <ESP8266HTTPClient.h>

// Configuración de la red WiFi
const char* ssid = "leandrog";
const char* password = "leandro123";
const char* server = "http://telemetria2024-1-eff133011f77.herokuapp.com/subirdatos.php";

// Configuración del RF24
#define CE_PIN 2
#define CSN_PIN 4
RF24 radio(CE_PIN, CSN_PIN);
byte addresses[][6] = {"16RF", "17RF"};
bool role = 0; // 0: receptor, 1: transmisor
unsigned long contador = 0;

void setup() {
  Serial.begin(115200);
  delay(10);

  // Inicio de la conexión WiFi
  WiFi.begin(ssid, password);
  while (WiFi.status() != WL_CONNECTED) {
    delay(1000);
    Serial.println("Conectando a WiFi...");
  }
  Serial.println("Conexión establecida...");

  // Configuración del RF24
  radio.begin();
  radio.setPALevel(RF24_PA_LOW);
  radio.openWritingPipe(addresses[0]);
  radio.openReadingPipe(1, addresses[1]);
  radio.startListening();
  radio.printDetails(); // Comenta esta línea si no necesitas detalles de la configuración RF24
}

void loop() {
  if (role == 0) { // Receptor
    float sensorValue;
    if (radio.available()) {
      radio.read(&sensorValue, sizeof(sensorValue));
      Serial.print(F("Temperatura Recibida: "));
      Serial.println(sensorValue);

      // Aquí comienza el bloque de código para enviar datos al servidor (POST)
      if (WiFi.status() == WL_CONNECTED) { // Verifica si estamos conectados a WiFi
        HTTPClient http;
        http.begin(server); // Inicializa la conexión con el servidor
        http.addHeader("Content-Type", "application/x-www-form-urlencoded"); // Encabezado HTTP

        String id_device = "0001"; // Identificador del dispositivo
        String postBody = "valor=" + String(sensorValue) + "&tipo=1" + "&id_device=" + id_device; // Cuerpo del POST
        Serial.println(postBody);
        int httpCode = http.POST(postBody); // Envía la solicitud POST
        
        if (httpCode > 0) {
          String payload = http.getString();
          Serial.print("Respuesta del servidor: ");
          Serial.println(payload);
        } else {
          Serial.print("Error en la solicitud, Código de error: ");
          Serial.println(httpCode);
        }
        http.end(); // Cierra la conexión HTTP
      }
      // Aquí termina el bloque de código POST
    }
  }
  delay(10000); // Espera antes de la próxima recepción y envío
}
