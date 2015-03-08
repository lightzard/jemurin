// TODO kalibrasi gerakan motor,
//      saat ini masih ada masalah dengan gerakan yang bolak-balik
#include <Arduino.h>
#include "Jemuran.h"

Jemuran::Jemuran(int LPRN, int LNRP) : LPRN_(LPRN), LNRP_(LNRP) {
  pinMode(LPRN_, OUTPUT);
  pinMode(LNRP_, OUTPUT);
  stop_();
  terbuka_ = false;
}

void Jemuran::stop_() {
  digitalWrite(LPRN_, LOW);
  digitalWrite(LNRP_, LOW);
}

void Jemuran::update() {
  if((signed long) (millis() - completeOn_) > 0) {
    stop_();
  }
}

void Jemuran::buka() {
  if(!terbuka_) {
    terbuka_ = true;
    completeOn_ = millis() + 2500;
    digitalWrite(LPRN_, HIGH);
    digitalWrite(LNRP_, LOW);
  }
}

void Jemuran::tutup() {
  if(terbuka_) {
    terbuka_ = false;
    completeOn_ = millis() + 2500;
    digitalWrite(LPRN_, LOW);
    digitalWrite(LNRP_, HIGH);
  }
}
