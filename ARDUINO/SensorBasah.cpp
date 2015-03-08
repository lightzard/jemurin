// TODO, harusnya ini di sampling lebih banyak lagi,
//       harusnya handle kondisi disekitar treshold, 

#include <Arduino.h>
#include "SensorBasah.h"

SensorBasah::SensorBasah(int input): input_(input) {
  pinMode(input_, INPUT);
  digitalWrite(input_, LOW);
  override_ = false;
  treshold = 300;
}

void SensorBasah::update() {
  if(!override_) lastValue_ = analogRead(input_);
}

bool SensorBasah::basah() {
  bool ret = false;
  return lastValue_ > treshold;
}

void SensorBasah::override(int data) {
  override_ = true;
  lastValue_ = data;
}

void SensorBasah::disableOverride() {
  override_ = false;
}
