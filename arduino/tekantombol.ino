#include <Ethernet.h>
#include <SPI.h>
//
byte mac[] = { 0x00, 0xAA, 0xBB, 0xCC, 0xDE, 0x01 }; // RESERVED MAC ADDRESS
EthernetClient client;
// the dns server ip
//IPAddress dnServer(192, 168, 43, 254);
// the router's gateway address:
//IPAddress gateway(192, 168, 1, 254);
// the subnet:
//IPAddress subnet(255, 255, 255, 0);

//the IP address is dependent on your network
IPAddress ip(192, 168, 1,2);


String data;


// Menyalakan LED dengan Aktif HIGH
int PIN_INPUT3 = 3; // type data yang berfungsi sebagai penyimpan bilangan bulat
int PIN_INPUT4 = 4; // type data yang berfungsi sebagai penyimpan bilangan bulat
int PIN_INPUT5 = 5; // type data yang berfungsi sebagai penyimpan bilangan bulat

int PIN_OUTPUT6 = 6; // type data yang berfungsi sebagai penyimpan bilangan bulat
int PIN_OUTPUT7 = 7; // type data yang berfungsi sebagai penyimpan bilangan bulat
int PIN_OUTPUT8 = 8; // type data yang berfungsi sebagai penyimpan bilangan bulat

bool uploading=false;
int STATUS_INPUT3=0;
int STATUS_INPUT4=0;
int STATUS_INPUT5=0;
String ipserver="192.168.1.1";
bool connected=false;
void createconnection(){
  Serial.println("createconnection");
  if (client.connect("192.168.1.1",80)) 
    { // REPLACE WITH YOUR SERVER ADDRESS
      if (client.connected()) { 
         connected=true;
         Serial.println("connected");
        //client.stop();  // DISCONNECT FROM THE SERVER
      }else{
        connected=false;
      }
    }else{
      Serial.println("createconnection error");
      connected=false;
    }
}
void readfromserver(){
  int i = client.read();
  Serial.print("Read Total:");
  Serial.println(i);
  if (i == -1) {
      connected=false;
      //break;
  }
}
void kirimkeserver(){
  if(connected==false){
    createconnection();
  }
  
   if(connected==true)
   {
     client.flush();
     client.println("POST /polling/save_polling.php HTTP/1.1"); 
     client.println("Host: 192.168.1.1"); // SERVER ADDRESS HERE TOO
     
     client.println("Connection: keep-alive");
     client.println("Keep-Alive: timeout=30, max=100");

     client.println("Content-Type: application/x-www-form-urlencoded"); 
     client.print("Content-Length: "); 
     client.println(data.length()); 
     client.println(); 
     client.print(data); 
     if(client.connected()){
       client.stop();
       connected=false;
     }
   }
}


void setup()
{
   Serial.begin(9600);
   // menjadikan PIN 4 sebagai OUTPUT
   Ethernet.begin(mac, ip);

    Serial.println(Ethernet.localIP());
    
   pinMode(PIN_OUTPUT6, OUTPUT); 
   pinMode(PIN_OUTPUT7, OUTPUT); 
   pinMode(PIN_OUTPUT8, OUTPUT); 
   
   pinMode(PIN_INPUT3, INPUT);
   pinMode(PIN_INPUT4, INPUT);
   pinMode(PIN_INPUT5, INPUT);
    
}
void loop()
{
  STATUS_INPUT3=digitalRead(PIN_INPUT3);
  STATUS_INPUT4=digitalRead(PIN_INPUT4);
  STATUS_INPUT5=digitalRead(PIN_INPUT5);
   if(STATUS_INPUT3==HIGH){
    //tombol merah
      digitalWrite(PIN_OUTPUT7, HIGH);
      if(uploading==false){
        uploading=true;
        data="polling=3";
        kirimkeserver();
        delay(3000);
      }
     // delay(3000);
   }else if(STATUS_INPUT4==HIGH){
    //tombol kuning
      digitalWrite(PIN_OUTPUT6, HIGH);
      if(uploading==false){
        uploading=true;
        data="polling=2";
       kirimkeserver();
        delay(3000);
      }
   }else if(STATUS_INPUT5==HIGH){
    //tombol hijau
      digitalWrite(PIN_OUTPUT8, HIGH);
      if(uploading==false){
        uploading=true;
        data="polling=1";
        kirimkeserver();
        delay(3000);
      }
   }else{
      digitalWrite(PIN_OUTPUT6, LOW);
      digitalWrite(PIN_OUTPUT7, LOW);
      digitalWrite(PIN_OUTPUT8, LOW);
      uploading=false;
   }
   //delay(1000);
}
