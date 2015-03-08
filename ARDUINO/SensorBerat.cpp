// TODO, harusnya ini di sampling lebih banyak lagi,

#include <Arduino.h>
#include "SensorBerat.h"

SensorBerat::SensorBerat(int input) : input_(input) {
  pinMode(input_, INPUT);
  digitalWrite(input_, LOW);
  override_ = false;
  treshold = 500;
}

void SensorBerat::update() {
  if(!override_) lastValue_ = analogRead(input_);

}

// Kondisi stabil adalah kondisi dimana berat beban jemuran tidak berkurang dalam waktu yang lama
// tapi karena ini prototipe, ya dimiripin aja kayak sensor basah
bool SensorBerat::stabil() {
  return lastValue_ > treshold;  
}

void SensorBerat::override(int data) {
  override_ = true;
  lastValue_ = data;
}

void SensorBerat::disableOverride() {
  override_ = false;
}
