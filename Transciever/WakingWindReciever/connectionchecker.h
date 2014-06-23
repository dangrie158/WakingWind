#ifndef CONNECTIONCHECKER_H
#define CONNECTIONCHECKER_H

#include <QDialog>
#include "qextserialport.h"
 #include <QTimer>

namespace Ui {
	class ConnectionChecker;
}

class ConnectionChecker : public QDialog
{
	Q_OBJECT
	
public:
	explicit ConnectionChecker(QWidget *parent = 0, QextSerialPort* port = 0);
	~ConnectionChecker();
	
private:
	Ui::ConnectionChecker *ui;
	QextSerialPort *port;
	QTimer *timer;
	int i;

private slots:
		void onReadyRead();
		void timeOut();
};

#endif // CONNECTIONCHECKER_H
