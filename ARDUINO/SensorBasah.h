#ifndef SensorBasah_H
#define SensorBasah_H

class SensorBasah {
private:
  int input_;
  int lastValue_;
  bool override_;
public:
  SensorBasah(int input);
  void update();
  bool basah();
  int treshold;
  void override(int data);
  void disableOverride();
};

#endif
