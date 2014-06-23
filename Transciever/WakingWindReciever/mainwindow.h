#ifndef MAINWINDOW_H
#define MAINWINDOW_H

#include <QMainWindow>
#include <qdatetime.h>
#include <config.h>
#include <QtSql>
#include "qextserialport.h"
#include "dataobject.h"
#include <QQueue>

#define SAMPLES_PER_HOUR (3600/48)

namespace Ui {
	class MainWindow;
}

class MainWindow : public QMainWindow
{
	Q_OBJECT
	
public:
	explicit MainWindow(QWidget *parent = 0);
	~MainWindow();

	void logMessage( const QString& message );
	
private slots:
	void on_actionClose_triggered();
	void on_actionOptions_triggered();
    void onReadyRead();
    void updateUI( DataObject* dataObject );
	void printSampleMessage( DataObject* dataObject );
	void dbInsert();
	void updateAvgStats( DataObject * );
	void updateRealtimeData( DataObject * );

signals:
    void sampleRecieved( DataObject* dataObject );

private:
	Ui::MainWindow *ui;
	Config *m_configWindow;
    QString *m_sSettingsFile;
    QextSerialPort *m_pPort;
    QSqlDatabase m_dbDatabase;

    QString m_sPortName;
    int m_iBaudRate;
    QString m_sURL;
    QString m_sServerPort;
    QString m_sDatabase;
    QString m_sUsername;
    QString m_sPassword;
    QString m_sLocId;
	DataObject *m_dCurrentDataObject;
	DataObject *m_dAvgDataObject;
	QTimer *m_tAvgTimer;

	QQueue<float>* m_qfRainfallQueue;

    void loadSettings();
    bool initializePort();
    bool initializeDb();
	unsigned int samplesInCurrentPackage;

    unsigned int stringToUInt( QString string );
    void parseData( QString data );
	void resetAvgStats();
	inline double round(double n, unsigned d)
	{
		  return floor(n * pow(10., d) + .5) / pow(10., d);
	}
};

#endif // MAINWINDOW_H
