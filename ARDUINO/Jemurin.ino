#include "Jemuran.h"
#include "SensorBasah.h"
#include "SensorBerat.h"

Jemuran *jemuran;
SensorBasah *basah;
SensorBerat *berat;

void setup()
{
  Serial.begin(9600);
  Serial.setTimeout(100);
  jemuran = new Jemuran(2, 3);
  basah = new SensorBasah(A0);
  berat = new SensorBerat(A1);
  delay(3000);
}

void prosesPerintah() {
  // TODO, proses perintah dari external,
  //       misalkan, query status, manual override, tunning, dan lainnya
}

bool sedangHujan = false;
void laporHujan() {
  if(!sedangHujan) {
    sedangHujan = true;
    Serial.print("hujan\r\n");
  }
}
void laporTidakHujan() {
  if(sedangHujan) {
    sedangHujan = false;
    Serial.print("tidakhujan\r\n");
  }
}

bool selesai = false;
void laporSudahKering() {
  selesai = true;
  Serial.print("kering\r\n");
}

void loop()
{
  prosesPerintah();
  
  jemuran->update();
  basah->update();
  berat->update();
  
  if(!selesai) {
    if(basah->basah()) {
      jemuran->tutup();
      laporHujan();
    } else {
      jemuran->buka();
      laporTidakHujan();
    }
    
    if(berat->stabil()) {
      laporSudahKering();
      jemuran->tutup();
    }
  }
  
  // TODO soft-reset

  delay(200);

}

