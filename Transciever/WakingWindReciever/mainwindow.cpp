#include "mainwindow.h"
#include "ui_mainwindow.h"
#include <QSettings>
#include <QMessageBox>

MainWindow::MainWindow( QWidget *parent ) :
	QMainWindow( parent ),
	ui( new Ui::MainWindow ),
	m_tAvgTimer( new QTimer() ),
	m_pPort( NULL ),
	samplesInCurrentPackage( 0 ),
	m_dAvgDataObject( new DataObject() ),
	m_dCurrentDataObject( new DataObject() ),
	m_qfRainfallQueue( new QQueue<float> )
{
	ui->setupUi(this);

    m_sSettingsFile = new QString( QApplication::applicationDirPath().left(1) + ":/config.ini" );

    loadSettings();
    if ( !initializePort() )
    {
        logMessage( "Could not open Port " + m_sPortName );
        QMessageBox ( QMessageBox::Warning,
                      "SetUp Needed", "Could not open Port " + m_sPortName,
                      QMessageBox::Ok,
                      this).exec();
    }if( !initializeDb() )
    {
        logMessage( "Could not connect to Database " + m_sURL );
        QMessageBox ( QMessageBox::Warning,
                      "SetUp Needed", "Could not connect to Database " + m_sURL,
                      QMessageBox::Ok,
                      this).exec();
    }

	connect( this, SIGNAL( sampleRecieved( DataObject* ) ), this, SLOT( updateUI( DataObject* ) ) );
	connect( this, SIGNAL( sampleRecieved( DataObject* ) ), this, SLOT( updateAvgStats( DataObject* ) ) );
	connect( this, SIGNAL( sampleRecieved( DataObject* ) ), this, SLOT( printSampleMessage( DataObject* ) ) );
	connect( this, SIGNAL( sampleRecieved(DataObject*) ), this, SLOT( updateRealtimeData(DataObject*) ) );

	connect( m_tAvgTimer, SIGNAL( timeout( ) ), this, SLOT( dbInsert( ) ) );
	//connect( m_tAvgTimer, SIGNAL( timeout( ) ), this, SLOT( resetAvgStats() ) );
}

MainWindow::~MainWindow()
{
	if( m_pPort != NULL )
    {
		if( m_pPort->isOpen() ) m_pPort->close();
		delete m_pPort;
    }
	m_dbDatabase.close();

	delete m_qfRainfallQueue;

	delete m_dCurrentDataObject;
	delete m_dAvgDataObject;

	delete m_tAvgTimer;
    delete m_sSettingsFile;
	delete ui;
}

void MainWindow::logMessage( const QString& message )
{
	int row = ui->logTable->rowCount();											// current row count
	ui->logTable->setRowCount(row+1);											// add one row
																				// create items in all added cells
	QString timestamp = QDateTime::currentDateTime().toString();
	QTableWidgetItem* timeItem = new QTableWidgetItem( timestamp );
	QTableWidgetItem* messageItem = new QTableWidgetItem( message );
	ui->logTable->setItem( row, 0, timeItem );
	ui->logTable->setItem( row, 1, messageItem );
}

void MainWindow::on_actionClose_triggered()
{
	this->close();
}

void MainWindow::on_actionOptions_triggered()
{
    m_configWindow = new Config(  m_sSettingsFile, this );
	m_configWindow->show();
}

void MainWindow::loadSettings()
{
    QSettings settings( "wwind", "Waking Wind" );

    if( settings.value("Port", "").toString().isEmpty() ||
        settings.value("Baud", "").toString().isEmpty() ||
        settings.value("URL", "").toString().isEmpty() ||
        settings.value("Database", "").toString().isEmpty() ||
        settings.value("User", "").toString().isEmpty() ||
        settings.value("Pass", "").toString().isEmpty() ||
        settings.value("ID", "").toString().isEmpty() )
    {

        QMessageBox ( QMessageBox::Information,
                      "SetUp Needed", "Please configure this Application first",
                      QMessageBox::Ok,
                      this).exec();

        Config configWindow( m_sSettingsFile, this );
        configWindow.setModal( true );
        configWindow.exec();
    }

    m_sPortName = settings.value( "Port", "" ).toString() ;
    m_iBaudRate = settings.value( "Baud", "" ).toInt();
    m_sURL = settings.value( "URL", "" ).toString();
    m_sServerPort = settings.value( "ServerPort", "" ).toString();
    m_sDatabase = settings.value( "Database", "" ).toString();
    m_sUsername = settings.value( "User", "" ).toString();
    m_sPassword = settings.value( "Pass", "" ).toString();
    m_sLocId = settings.value( "ID", "" ).toString();
}

bool MainWindow::initializePort()
{
    foreach (QextPortInfo info, QextSerialEnumerator::getPorts())
        if( info.portName == m_sPortName )
        {
            PortSettings settings = {(BaudRateType)m_iBaudRate, DATA_8, PAR_NONE, STOP_1, FLOW_OFF, 10};
            m_pPort = new QextSerialPort(m_sPortName, settings, QextSerialPort::EventDriven);
            m_pPort->open(QIODevice::ReadWrite);
            connect(m_pPort, SIGNAL(readyRead()), SLOT(onReadyRead()));

        }
	if( m_pPort != NULL )
		return m_pPort->isOpen();
	return false;
}

bool MainWindow::initializeDb()
{
    m_dbDatabase = QSqlDatabase::addDatabase("QMYSQL");
    m_dbDatabase.setHostName( m_sURL );
    if( !m_sServerPort.isEmpty() )
    {
        m_dbDatabase.setPort( m_sServerPort.toInt() );
    }
    m_dbDatabase.setDatabaseName( m_sDatabase );
    m_dbDatabase.setUserName( m_sUsername );
    m_dbDatabase.setPassword( m_sPassword );
    bool ret = m_dbDatabase.open();
    if( ret )
    {
        m_dbDatabase.close();
    }
    return ret;
}

void MainWindow::onReadyRead()
{
    QString data = QString::fromLatin1( m_pPort->readAll() );
    if( data.length() < 170 )
    {
        ui->dataQualityBox->setValue( 0 );
    }else
    {
        parseData( data );
    }
}

void MainWindow::parseData( QString data )
{
    QString::Iterator i;
    QString recognizedData;
	int packetsRecieved = 0, dataquality = 100;
    for( i=data.begin(); i!=data.end(); i++ )
    {
        if( (*i) == 'n' )
        {
			//ToDo: ToDo?
        }
        else if( (*i) == '1' )
        {
            recognizedData += "1";
        }
        else if( (*i) == '0' )
        {
            recognizedData += "0";
        }
        else
        {
            dataquality--;
        }
        packetsRecieved++;
    }



    if( recognizedData.length() > 85 )
    {
        int dataStart = recognizedData.indexOf( '0', 2 );
        dataquality -= abs( 9 - dataStart );

        QString dataFrame = recognizedData.right(recognizedData.length() - dataStart);

        QString batdatString = dataFrame.mid( 1, 4 );
        QString uidString = dataFrame.mid( 5, 4 );
        QString tempString = dataFrame.mid( 13, 10 );
        QString humidString = dataFrame.mid( 23, 8 );
        QString windsString = dataFrame.mid( 31, 16 );
        QString rainfString = dataFrame.mid( 47, 16 );
        QString winddString = dataFrame.mid( 67, 4 );
        QString checksumString = dataFrame.mid( 71, 8 );

        int batData = stringToUInt( batdatString );
        float temp = (((float)stringToUInt( tempString ))-400.0f)/10.0f;
        int humid = stringToUInt( humidString );
        float winds = ((float)(stringToUInt( windsString )))/240;
        float rainf = ((float)stringToUInt( rainfString ))*0.3f;
        DataObject::WindDir windd = (DataObject::WindDir)stringToUInt( winddString );
        unsigned int uid = stringToUInt( uidString );


		if( m_qfRainfallQueue->length() >= SAMPLES_PER_HOUR )
		{
			float temprainf = rainf - m_qfRainfallQueue->dequeue();

			if( temprainf < 0 ){
				rainf = 0;
			}else{
				rainf = temprainf;
			}
		}
		m_qfRainfallQueue->enqueue( rainf );

		m_dCurrentDataObject->setBatData( batData );
		m_dCurrentDataObject->setUID( uid );
		m_dCurrentDataObject->setTemperature( temp );
		m_dCurrentDataObject->setHumidity( humid );
		m_dCurrentDataObject->setWindspeed( winds );
		m_dCurrentDataObject->setRainfall( rainf );
		m_dCurrentDataObject->setWinddir( windd );
		m_dCurrentDataObject->setChecksum( checksumString );

		emit sampleRecieved( m_dCurrentDataObject );
		if( !m_tAvgTimer->isActive() )
		{
			m_tAvgTimer->setInterval( 300000 );
			m_tAvgTimer->start();
		}

		ui->packetsRecvBox->setText( QString::number( ui->packetsRecvBox->text().toInt() + 1 ) );
		ui->dataQualityBox->setValue( dataquality );
    }else
    {
        ui->dataQualityBox->setValue( 0 );
        ui->packDropBox->setText( QString::number( ui->packDropBox->text().toInt() + 1 ) );
    }
}

unsigned int MainWindow::stringToUInt( QString string )
{
    QString::Iterator i;
    unsigned int ret = 0, j = 0;

    for( i = string.begin(); i != string.end(); i++ )
    {

        if( (*i) == '1' )
        {
            ret |= 1 << ((string.length()-1)-j);
        }
        else
        {
            ret &= ~(1 << ((string.length()-1)-j));
        }
        j++;
    }

    return ret;
}

void MainWindow::updateUI( DataObject *dataObject )
{
    ui->tempBox->display( dataObject->temperature() );
    ui->humidBox->display( dataObject->humidity() );
    ui->wsBox->display( dataObject->windspeed() );
    ui->rfBox->display( dataObject->rainfall() );
    QImage image;
    switch( dataObject->winddir() )
    {
    case DataObject::N:
            image = QImage(":/windrose/res/N.png");
        break;
    case DataObject::NE:
            image = QImage(":/windrose/res/NO.png");
        break;
    case DataObject::E:
            image = QImage(":/windrose/res/O.png");
        break;
    case DataObject::SE:
            image = QImage(":/windrose/res/SO.png");
        break;
    case DataObject::S:
            image = QImage(":/windrose/res/S.png");
        break;
    case DataObject::SW:
            image = QImage(":/windrose/res/SW.png");
        break;
    case DataObject::W:
            image = QImage(":/windrose/res/W.png");
        break;
    case DataObject::NW:
            image = QImage(":/windrose/res/NW.png");
        break;
    }
    ui->wdBox->setPixmap( QPixmap::fromImage( image ) );
	ui->uidBox->setText( QString::number(m_dCurrentDataObject->uid()) );

	ui->windsDegBox->setText( QString::number( dataObject->winddir() * 22.5f ) + QString::fromUtf8( "°" ) );
}

void MainWindow::dbInsert( )
{
	if( samplesInCurrentPackage > 0 )
	{
		m_dbDatabase.open();
		if( !m_dbDatabase.isOpen() )
		{
			logMessage( "Database is not open" );
		}
		QSqlQuery query;
        query.prepare( "INSERT INTO average_data_loc_" + m_sLocId + " ( temperature, humidity, windspeed, winddir, rainfall ) VALUES ( :temperature, :humidity, :windspeed, :winddir, :rainfall )" );
		query.bindValue( ":temperature", m_dAvgDataObject->temperature() );
		query.bindValue( ":humidity", m_dAvgDataObject->humidity() );
		query.bindValue( ":windspeed", m_dAvgDataObject->windspeed() * 0.54f );
		query.bindValue( ":winddir", m_dAvgDataObject->winddir() );
		query.bindValue( ":rainfall", m_dAvgDataObject->rainfall() );
		if( !query.exec() )
		{
			logMessage( query.lastError().text() );
		}

		m_dbDatabase.close();
		resetAvgStats();
	}
}

void MainWindow::updateAvgStats( DataObject* )
{
	m_dAvgDataObject->setTemperature( ( m_dAvgDataObject->temperature()*samplesInCurrentPackage +
										m_dCurrentDataObject->temperature() ) / (samplesInCurrentPackage + 1 ) );
	m_dAvgDataObject->setHumidity( ( m_dAvgDataObject->humidity() * samplesInCurrentPackage  +
								   m_dCurrentDataObject->humidity() ) / (samplesInCurrentPackage + 1 ) );
	m_dAvgDataObject->setWindspeed( ( m_dAvgDataObject->windspeed() * samplesInCurrentPackage +
								   m_dCurrentDataObject->windspeed() ) / (samplesInCurrentPackage + 1 ) );
	m_dAvgDataObject->setWinddir( m_dCurrentDataObject->winddir() );
	m_dAvgDataObject->setRainfall( ( m_dAvgDataObject->rainfall() * samplesInCurrentPackage +
									 m_dCurrentDataObject->rainfall() ) / (samplesInCurrentPackage + 1) );
	samplesInCurrentPackage++;
}

void MainWindow::printSampleMessage( DataObject* dataObject )
{
	QString message;
	message += "Sample# " + ui->packetsRecvBox->text();
	message += "\t" + QString::number( dataObject->temperature() ) + QString::fromUtf8("°C"); //ToDo: Remove?
	message += "\t" + QString::number( dataObject->humidity() ) + "%Rh";
	message += "\t" + QString::number( round( dataObject->windspeed() ,2 ) ) + "kts";
	message += "\t" + QString::number( round( dataObject->rainfall(),2 ) ) + "mm/h";
	qDebug()<<message;
}

void MainWindow::resetAvgStats()
{
	samplesInCurrentPackage = 0;
	delete m_dAvgDataObject;
	m_dAvgDataObject = new DataObject();
}

void MainWindow::updateRealtimeData( DataObject * )
{
	m_dbDatabase.open();
	if( !m_dbDatabase.isOpen() )
	{
		logMessage( "Database is not open" );
	}
	QSqlQuery query;
	query.prepare( QString( "UPDATE realtime_data SET timestamp = NOW(), " ) +
					QString( "temperature = :temperature, " ) +
					QString( "humidity = :humidity, " ) +
					QString( "windspeed = :windspeed, " ) +
					QString( "winddir = :winddir, " ) +
					QString( "rainfall = :rainfall " ) +
                   QString( "WHERE loc_id =" ) + m_sLocId );
	query.bindValue( ":locid", 1 );
	query.bindValue( ":temperature", m_dCurrentDataObject->temperature() );
	query.bindValue( ":humidity", m_dCurrentDataObject->humidity() );
	query.bindValue( ":windspeed", m_dCurrentDataObject->windspeed() * 0.54f );
	query.bindValue( ":winddir", m_dCurrentDataObject->winddir() );
	query.bindValue( ":rainfall", m_dCurrentDataObject->rainfall() );
	if( !query.exec() )
	{
		logMessage( query.lastError().text() );
	}

	m_dbDatabase.close();
}
