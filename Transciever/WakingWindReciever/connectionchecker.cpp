#include "connectionchecker.h"
#include "ui_connectionchecker.h"

ConnectionChecker::ConnectionChecker(QWidget *parent, QextSerialPort* port) :
	QDialog(parent),
	ui(new Ui::ConnectionChecker),
	i(0)
{
	ui->setupUi(this);
	this->port = port;
	timer = new QTimer(this);
	timer->setInterval(40);
	timer->start();

	if( !port->isOpen() )
	{
		ui->statusLabel->setText( "Port is Closed" );
		timer->stop();
	}else if( !port->isReadable() )
	{
		ui->statusLabel->setText( "Port is unreadable" );
		timer->stop();
	}else
	{
		ui->statusLabel->setText( "Port OK, Waiting for Data" );
	}

	connect(timer, SIGNAL(timeout()), SLOT(timeOut()));
	connect(port, SIGNAL(readyRead()), SLOT(onReadyRead()));
}

ConnectionChecker::~ConnectionChecker()
{
	delete ui;
	delete timer;
}

void ConnectionChecker::onReadyRead()
{
		QString data = QString::fromLatin1(port->readAll());
		if( data.length() > 170 )
		{
			ui->statusLabel->setText( "Port OK, Data Recieved" );
			ui->cancelButton->setText( "Close" );
			timer->stop();
		}
		else
		{
			ui->statusLabel->setText( "Can't properply recieve Data, change BaudRate" );
			timer->stop();
		}
}

void ConnectionChecker::timeOut()
{
	i++;
	if( i > 5000 )
	{
		ui->statusLabel->setText( "No Data Recieved, Change Port" );
		timer->stop();
	}
	QProgressBar* bar = ui->statusBar;
	bar->setValue(bar->value()+1);
	if( bar->value() > 99 )
		bar->setValue(0);
}
