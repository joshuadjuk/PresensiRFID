#include <ESP8266WebServer.h>
#include <ESP8266HTTPClient.h>
#include <SPI.h>
#include <MFRC522.h>

// Define pin connections
#define SS_PIN D2         // SDA / SS pin
#define RST_PIN D1        // RST pin
#define ON_BOARD_LED 2    // On-board LED for status indication
#define buzzer D0
#define led D8

// Create MFRC522 instance
MFRC522 mfrc522(SS_PIN, RST_PIN);

// WiFi credentials
const char* ssid = "Kontrakan Lt.2";
const char* password = "gamau1234567890";

// Create server instance on port 80
ESP8266WebServer server(80);

int readsuccess;
byte readcard[4];
char str[32] = "";
String StrUID;

void setup() {
  Serial.begin(115200);  // Initialize serial communication with PC
  SPI.begin();           // Initialize SPI bus
  mfrc522.PCD_Init();    // Initialize MFRC522

  delay(500);

  // Connect to WiFi
  WiFi.begin(ssid, password);
  Serial.println("");

  pinMode(ON_BOARD_LED, OUTPUT);
  digitalWrite(ON_BOARD_LED, HIGH);  // Turn off on-board LED
  pinMode(buzzer,OUTPUT);
  pinMode(led,OUTPUT);
  // Wait for connection
  Serial.print("Connecting");
  while (WiFi.status() != WL_CONNECTED) {
    Serial.print(".");
    digitalWrite(ON_BOARD_LED, LOW);  // Flash LED while connecting
    delay(250);
    digitalWrite(ON_BOARD_LED, HIGH);
    delay(250);
  }
  digitalWrite(ON_BOARD_LED, HIGH);  // Turn off LED when connected
  Serial.println("");
  Serial.print("Successfully connected to: ");
  Serial.println(ssid);
  Serial.print("IP address: ");
  Serial.println(WiFi.localIP());

  Serial.println("Please tag a card or keychain to see the UID!");
  Serial.println("");
}
