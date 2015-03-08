#ifndef SensorBerat_H
#define SensorBerat_H

class SensorBerat {
private:
public:
  int input_;
  int lastValue_;
  bool override_;
  SensorBerat(int input);
  void update();
  bool stabil();
  int treshold;
  void override(int data);
  void disableOverride();
};

#endif
