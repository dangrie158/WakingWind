#ifndef CONFIG_H
#define CONFIG_H

#include <QDialog>
#include <QAbstractButton>
#include "qextserialport.h"
#include "qextserialenumerator.h"

namespace Ui {
	class Config;
}

class Config : public QDialog
{
	Q_OBJECT
	
public:
    explicit Config( QString *settingsFile, QWidget *parent = 0 );
	~Config();
	
private slots:
	void on_testSettingsButton_clicked();
	void onPortAddedOrRemoved();
	void onPortNameChanged(const QString &name);
	void onBaudRateChanged(int idx);

    void on_testConnectionButton_clicked();
    void on_buttonBox_clicked(QAbstractButton *button);

private:
	Ui::Config *ui;
	QextSerialPort *port;
	QextSerialEnumerator *enumerator;
    QString *m_sSettingsFile;

    void loadSettings();
    void saveSettings();
};

#endif // CONFIG_H
