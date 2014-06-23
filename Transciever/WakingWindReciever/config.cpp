#include "config.h"
#include "ui_config.h"
#include <connectionchecker.h>
#include <QMessageBox>
#include <QtSql>
#include <QtConfig>

Config::Config(QString *settingsFile, QWidget *parent) :
    QDialog( parent ),
	ui(new Ui::Config)
{
	ui->setupUi(this);

    this->m_sSettingsFile = settingsFile;

	foreach (QextPortInfo info, QextSerialEnumerator::getPorts())
		ui->portBox->addItem( info.portName );
		//make sure user can input their own port name!
	ui->portBox->setEditable( true );

	ui->baudRateBox->addItem( "1200", BAUD1200 );
	ui->baudRateBox->addItem( "2400", BAUD2400 );
	ui->baudRateBox->addItem( "4800", BAUD4800 );
	ui->baudRateBox->addItem( "9600", BAUD9600 );
	ui->baudRateBox->addItem( "38400", BAUD38400 );
	ui->baudRateBox->addItem( "19200", BAUD19200 );
	ui->baudRateBox->setCurrentIndex( 4 );

	PortSettings settings = {BAUD38400, DATA_8, PAR_NONE, STOP_1, FLOW_OFF, 10};
	port = new QextSerialPort(ui->portBox->currentText(), settings, QextSerialPort::EventDriven);

	connect(ui->baudRateBox, SIGNAL(currentIndexChanged(int)), SLOT(onBaudRateChanged(int)));
	connect(ui->portBox, SIGNAL(editTextChanged(QString)), SLOT(onPortNameChanged(QString)));

	enumerator = new QextSerialEnumerator(this);
	enumerator->setUpNotifications();
	connect(enumerator, SIGNAL(deviceDiscovered(QextPortInfo)), SLOT(onPortAddedOrRemoved()));
	connect(enumerator, SIGNAL(deviceRemoved(QextPortInfo)), SLOT(onPortAddedOrRemoved()));

    loadSettings();
}

Config::~Config()
{
	delete ui;
	delete port;
}

void Config::onPortNameChanged(const QString & /*name*/)
{
	if (port->isOpen()) {
		port->close();
	}
	port->setPortName(ui->portBox->currentText());
}

void Config::onBaudRateChanged(int idx)
{
	port->setBaudRate((BaudRateType)ui->baudRateBox->itemData(idx).toInt());
}

void Config::on_testSettingsButton_clicked()
{
	if (!port->isOpen()) {
			port->setPortName(ui->portBox->currentText());
			port->open(QIODevice::ReadWrite);
		}
	ConnectionChecker connChk( this, port );
	connChk.setModal( true );
	connChk.exec();
}

void Config::onPortAddedOrRemoved()
{
	QString current = ui->portBox->currentText();

	ui->portBox->blockSignals(true);
	ui->portBox->clear();
	foreach (QextPortInfo info, QextSerialEnumerator::getPorts())
		ui->portBox->addItem(info.portName);

	ui->portBox->setCurrentIndex(ui->portBox->findText(current));

	ui->portBox->blockSignals(false);
}

void Config::on_testConnectionButton_clicked()
{
    QSqlDatabase db = QSqlDatabase::addDatabase("QMYSQL");
    db.setHostName( ui->urlBox->text() );
    if( !ui->serverPortBox->text().isEmpty() )
    {
        db.setPort( ui->serverPortBox->text().toInt() );
    }
    db.setDatabaseName( ui->databaseBox->text() );
    db.setUserName( ui->userBox->text() );
    db.setPassword( ui->passwortBox->text() );
    if (!db.open())
    {
        QMessageBox ( QMessageBox::Critical,
                      "Connection Failed", "Could not connect to Database",
                      QMessageBox::Ok,
                      this).exec();
    }else
    {
        QMessageBox ( QMessageBox::Information,
                      "Connection Succeded", "Connection to Database established",
                      QMessageBox::Ok,
                      this).exec();
    }
    db.close();
}

void Config::loadSettings()
{
    QSettings settings( "wwind", "Waking Wind" );

    ui->portBox->setEditText( settings.value( "Port", "" ).toString() );
    ui->baudRateBox->setEditText( settings.value( "Baud", "" ).toString() );
    ui->urlBox->setText( settings.value( "URL", "" ).toString() );
    ui->serverPortBox->setText( settings.value( "ServerPort", "" ).toString() );
    ui->databaseBox->setText( settings.value( "Database", "" ).toString() );
    ui->userBox->setText( settings.value( "User", "" ).toString() );
    ui->passwortBox->setText( settings.value( "Pass", "" ).toString() );
    ui->idBox->setText( settings.value( "ID", "" ).toString() );
}

void Config::saveSettings()
{
    QSettings settings( "wwind", "Waking Wind" );

    QString portBoxText = ui->portBox->currentText();
    QString baudRateBoxText = ui->baudRateBox->currentText();
    QString URLText = ui->urlBox->text();
    QString serverPortBoxText = ui->serverPortBox->text();
    QString databaseBoxText = ui->databaseBox->text();
    QString userBoxText = ui->userBox->text();
    QString passwortBoxText = ui->passwortBox->text();
    QString idBoxText = ui->idBox->text();

    settings.setValue("Port", portBoxText);
    settings.setValue("Baud", baudRateBoxText);
    settings.setValue("URL", URLText);
    settings.setValue("ServerPort", serverPortBoxText);
    settings.setValue("Database", databaseBoxText);
    settings.setValue("User", userBoxText);
    settings.setValue("Pass", passwortBoxText);
    settings.setValue("ID", idBoxText);
}

void Config::on_buttonBox_clicked(QAbstractButton *button)
{
    if( button->text() == "Save" )
    {
        saveSettings();
    }
}
