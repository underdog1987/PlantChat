float temperatura;
int lecA0;

float iluminacion;
int lecA1;

float humedad;
int lecA2;
void setup(){

  Serial.begin(9600);
  
}

void loop(){
  //if(Serial.available()){
   /* Temperatura */ 
   lecA0 = analogRead(0);
   temperatura = (5.0*lecA0*100.0)/1024.0;

   /* Humedad */
   lecA1 = analogRead(1);
   humedad = (100.0/1024.0)*lecA1;
   
   /* Iluminacion */
   lecA2 = iluminacion = analogRead(2);

   Serial.print("T=");
   Serial.print(temperatura);
   Serial.print("|H=");
   Serial.print(humedad);
   Serial.print("|I=");
   //Serial.println(iluminacion);
   Serial.println(255);
   delay(10000);
    
  //}
}
