#ifndef Jemuran_H
#define Jemuran_H

class Jemuran {
private:
  int LPRN_;
  int LNRP_;
  void stop_();
  bool terbuka_;
  long proses_;
  unsigned long completeOn_;
public:
  Jemuran(int LPRN, int LNRP);
  void update();
  void buka();
  void tutup();
};

#endif
