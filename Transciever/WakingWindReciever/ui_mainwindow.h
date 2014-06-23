/********************************************************************************
** Form generated from reading UI file 'mainwindow.ui'
**
** Created: Fri Jun 14 18:30:09 2013
**      by: Qt User Interface Compiler version 4.8.2
**
** WARNING! All changes made in this file will be lost when recompiling UI file!
********************************************************************************/

#ifndef UI_MAINWINDOW_H
#define UI_MAINWINDOW_H

#include <QtCore/QVariant>
#include <QtGui/QAction>
#include <QtGui/QApplication>
#include <QtGui/QButtonGroup>
#include <QtGui/QGridLayout>
#include <QtGui/QGroupBox>
#include <QtGui/QHeaderView>
#include <QtGui/QLCDNumber>
#include <QtGui/QLabel>
#include <QtGui/QMainWindow>
#include <QtGui/QMenu>
#include <QtGui/QMenuBar>
#include <QtGui/QProgressBar>
#include <QtGui/QStatusBar>
#include <QtGui/QTabWidget>
#include <QtGui/QTableWidget>
#include <QtGui/QToolBar>
#include <QtGui/QWidget>

QT_BEGIN_NAMESPACE

class Ui_MainWindow
{
public:
    QAction *actionClose;
    QAction *actionOptions;
    QWidget *centralWidget;
    QGridLayout *gridLayout;
    QTabWidget *tabWidget;
    QWidget *tab;
    QGridLayout *gridLayout_3;
    QGroupBox *groupBox;
    QGridLayout *gridLayout_4;
    QLCDNumber *wsBox;
    QLabel *label_13;
    QLabel *label_12;
    QLabel *label_10;
    QLabel *label_11;
    QLCDNumber *tempBox;
    QLabel *label;
    QLCDNumber *rfBox;
    QLabel *label_5;
    QLabel *label_4;
    QLabel *label_3;
    QLabel *label_2;
    QLCDNumber *humidBox;
    QLabel *windsDegBox;
    QLabel *wdBox;
    QGroupBox *groupBox_2;
    QGridLayout *gridLayout_5;
    QProgressBar *dataQualityBox;
    QLabel *label_6;
    QGridLayout *gridLayout_6;
    QLabel *label_8;
    QLabel *packetsRecvBox;
    QLabel *label_9;
    QLabel *packDropBox;
    QLabel *label_7;
    QLabel *uidBox;
    QWidget *tab_2;
    QGridLayout *gridLayout_2;
    QTableWidget *logTable;
    QMenuBar *menuBar;
    QMenu *menuFile;
    QToolBar *mainToolBar;
    QStatusBar *statusBar;

    void setupUi(QMainWindow *MainWindow)
    {
        if (MainWindow->objectName().isEmpty())
            MainWindow->setObjectName(QString::fromUtf8("MainWindow"));
        MainWindow->resize(507, 489);
        QSizePolicy sizePolicy(QSizePolicy::Fixed, QSizePolicy::Fixed);
        sizePolicy.setHorizontalStretch(0);
        sizePolicy.setVerticalStretch(0);
        sizePolicy.setHeightForWidth(MainWindow->sizePolicy().hasHeightForWidth());
        MainWindow->setSizePolicy(sizePolicy);
        actionClose = new QAction(MainWindow);
        actionClose->setObjectName(QString::fromUtf8("actionClose"));
        actionOptions = new QAction(MainWindow);
        actionOptions->setObjectName(QString::fromUtf8("actionOptions"));
        centralWidget = new QWidget(MainWindow);
        centralWidget->setObjectName(QString::fromUtf8("centralWidget"));
        gridLayout = new QGridLayout(centralWidget);
        gridLayout->setSpacing(6);
        gridLayout->setContentsMargins(11, 11, 11, 11);
        gridLayout->setObjectName(QString::fromUtf8("gridLayout"));
        tabWidget = new QTabWidget(centralWidget);
        tabWidget->setObjectName(QString::fromUtf8("tabWidget"));
        tabWidget->setStyleSheet(QString::fromUtf8(""));
        tab = new QWidget();
        tab->setObjectName(QString::fromUtf8("tab"));
        gridLayout_3 = new QGridLayout(tab);
        gridLayout_3->setSpacing(6);
        gridLayout_3->setContentsMargins(11, 11, 11, 11);
        gridLayout_3->setObjectName(QString::fromUtf8("gridLayout_3"));
        groupBox = new QGroupBox(tab);
        groupBox->setObjectName(QString::fromUtf8("groupBox"));
        QSizePolicy sizePolicy1(QSizePolicy::Preferred, QSizePolicy::Preferred);
        sizePolicy1.setHorizontalStretch(0);
        sizePolicy1.setVerticalStretch(2);
        sizePolicy1.setHeightForWidth(groupBox->sizePolicy().hasHeightForWidth());
        groupBox->setSizePolicy(sizePolicy1);
        gridLayout_4 = new QGridLayout(groupBox);
        gridLayout_4->setSpacing(6);
        gridLayout_4->setContentsMargins(11, 11, 11, 11);
        gridLayout_4->setObjectName(QString::fromUtf8("gridLayout_4"));
        wsBox = new QLCDNumber(groupBox);
        wsBox->setObjectName(QString::fromUtf8("wsBox"));
        QSizePolicy sizePolicy2(QSizePolicy::Preferred, QSizePolicy::Preferred);
        sizePolicy2.setHorizontalStretch(0);
        sizePolicy2.setVerticalStretch(0);
        sizePolicy2.setHeightForWidth(wsBox->sizePolicy().hasHeightForWidth());
        wsBox->setSizePolicy(sizePolicy2);
        wsBox->setFrameShape(QFrame::NoFrame);
        wsBox->setProperty("value", QVariant(0));
        wsBox->setProperty("intValue", QVariant(0));

        gridLayout_4->addWidget(wsBox, 1, 1, 1, 1);

        label_13 = new QLabel(groupBox);
        label_13->setObjectName(QString::fromUtf8("label_13"));

        gridLayout_4->addWidget(label_13, 1, 6, 1, 1);

        label_12 = new QLabel(groupBox);
        label_12->setObjectName(QString::fromUtf8("label_12"));

        gridLayout_4->addWidget(label_12, 0, 6, 1, 1);

        label_10 = new QLabel(groupBox);
        label_10->setObjectName(QString::fromUtf8("label_10"));
        QSizePolicy sizePolicy3(QSizePolicy::Minimum, QSizePolicy::Minimum);
        sizePolicy3.setHorizontalStretch(0);
        sizePolicy3.setVerticalStretch(0);
        sizePolicy3.setHeightForWidth(label_10->sizePolicy().hasHeightForWidth());
        label_10->setSizePolicy(sizePolicy3);

        gridLayout_4->addWidget(label_10, 0, 2, 1, 1);

        label_11 = new QLabel(groupBox);
        label_11->setObjectName(QString::fromUtf8("label_11"));
        sizePolicy3.setHeightForWidth(label_11->sizePolicy().hasHeightForWidth());
        label_11->setSizePolicy(sizePolicy3);

        gridLayout_4->addWidget(label_11, 1, 2, 1, 1);

        tempBox = new QLCDNumber(groupBox);
        tempBox->setObjectName(QString::fromUtf8("tempBox"));
        sizePolicy2.setHeightForWidth(tempBox->sizePolicy().hasHeightForWidth());
        tempBox->setSizePolicy(sizePolicy2);
        QFont font;
        font.setStrikeOut(false);
        tempBox->setFont(font);
        tempBox->setAutoFillBackground(false);
        tempBox->setFrameShape(QFrame::NoFrame);
        tempBox->setFrameShadow(QFrame::Raised);
        tempBox->setSmallDecimalPoint(false);
        tempBox->setSegmentStyle(QLCDNumber::Filled);
        tempBox->setProperty("value", QVariant(0));

        gridLayout_4->addWidget(tempBox, 0, 1, 1, 1);

        label = new QLabel(groupBox);
        label->setObjectName(QString::fromUtf8("label"));
        label->setAlignment(Qt::AlignRight|Qt::AlignTrailing|Qt::AlignVCenter);

        gridLayout_4->addWidget(label, 0, 0, 1, 1);

        rfBox = new QLCDNumber(groupBox);
        rfBox->setObjectName(QString::fromUtf8("rfBox"));
        sizePolicy2.setHeightForWidth(rfBox->sizePolicy().hasHeightForWidth());
        rfBox->setSizePolicy(sizePolicy2);
        rfBox->setFrameShape(QFrame::NoFrame);

        gridLayout_4->addWidget(rfBox, 1, 5, 1, 1);

        label_5 = new QLabel(groupBox);
        label_5->setObjectName(QString::fromUtf8("label_5"));
        label_5->setAlignment(Qt::AlignRight|Qt::AlignTrailing|Qt::AlignVCenter);

        gridLayout_4->addWidget(label_5, 1, 4, 1, 1);

        label_4 = new QLabel(groupBox);
        label_4->setObjectName(QString::fromUtf8("label_4"));
        label_4->setAlignment(Qt::AlignRight|Qt::AlignTrailing|Qt::AlignVCenter);

        gridLayout_4->addWidget(label_4, 3, 0, 1, 1);

        label_3 = new QLabel(groupBox);
        label_3->setObjectName(QString::fromUtf8("label_3"));
        label_3->setAlignment(Qt::AlignRight|Qt::AlignTrailing|Qt::AlignVCenter);

        gridLayout_4->addWidget(label_3, 1, 0, 1, 1);

        label_2 = new QLabel(groupBox);
        label_2->setObjectName(QString::fromUtf8("label_2"));
        label_2->setAlignment(Qt::AlignRight|Qt::AlignTrailing|Qt::AlignVCenter);

        gridLayout_4->addWidget(label_2, 0, 4, 1, 1);

        humidBox = new QLCDNumber(groupBox);
        humidBox->setObjectName(QString::fromUtf8("humidBox"));
        sizePolicy2.setHeightForWidth(humidBox->sizePolicy().hasHeightForWidth());
        humidBox->setSizePolicy(sizePolicy2);
        humidBox->setFrameShape(QFrame::NoFrame);
        humidBox->setSmallDecimalPoint(false);
        humidBox->setProperty("value", QVariant(0));
        humidBox->setProperty("intValue", QVariant(0));

        gridLayout_4->addWidget(humidBox, 0, 5, 1, 1);

        windsDegBox = new QLabel(groupBox);
        windsDegBox->setObjectName(QString::fromUtf8("windsDegBox"));
        sizePolicy3.setHeightForWidth(windsDegBox->sizePolicy().hasHeightForWidth());
        windsDegBox->setSizePolicy(sizePolicy3);

        gridLayout_4->addWidget(windsDegBox, 3, 4, 1, 1);

        wdBox = new QLabel(groupBox);
        wdBox->setObjectName(QString::fromUtf8("wdBox"));
        sizePolicy2.setHeightForWidth(wdBox->sizePolicy().hasHeightForWidth());
        wdBox->setSizePolicy(sizePolicy2);
        wdBox->setPixmap(QPixmap(QString::fromUtf8(":/windrose/res/N.png")));
        wdBox->setScaledContents(false);
        wdBox->setAlignment(Qt::AlignCenter);

        gridLayout_4->addWidget(wdBox, 3, 2, 1, 1);


        gridLayout_3->addWidget(groupBox, 0, 0, 1, 1);

        groupBox_2 = new QGroupBox(tab);
        groupBox_2->setObjectName(QString::fromUtf8("groupBox_2"));
        gridLayout_5 = new QGridLayout(groupBox_2);
        gridLayout_5->setSpacing(6);
        gridLayout_5->setContentsMargins(11, 11, 11, 11);
        gridLayout_5->setObjectName(QString::fromUtf8("gridLayout_5"));
        dataQualityBox = new QProgressBar(groupBox_2);
        dataQualityBox->setObjectName(QString::fromUtf8("dataQualityBox"));
        dataQualityBox->setValue(0);

        gridLayout_5->addWidget(dataQualityBox, 0, 1, 1, 1);

        label_6 = new QLabel(groupBox_2);
        label_6->setObjectName(QString::fromUtf8("label_6"));
        label_6->setAlignment(Qt::AlignRight|Qt::AlignTrailing|Qt::AlignVCenter);

        gridLayout_5->addWidget(label_6, 0, 0, 1, 1);

        gridLayout_6 = new QGridLayout();
        gridLayout_6->setSpacing(6);
        gridLayout_6->setObjectName(QString::fromUtf8("gridLayout_6"));
        label_8 = new QLabel(groupBox_2);
        label_8->setObjectName(QString::fromUtf8("label_8"));
        label_8->setAlignment(Qt::AlignRight|Qt::AlignTrailing|Qt::AlignVCenter);

        gridLayout_6->addWidget(label_8, 0, 2, 1, 1);

        packetsRecvBox = new QLabel(groupBox_2);
        packetsRecvBox->setObjectName(QString::fromUtf8("packetsRecvBox"));

        gridLayout_6->addWidget(packetsRecvBox, 0, 1, 1, 1);

        label_9 = new QLabel(groupBox_2);
        label_9->setObjectName(QString::fromUtf8("label_9"));
        label_9->setAlignment(Qt::AlignRight|Qt::AlignTrailing|Qt::AlignVCenter);

        gridLayout_6->addWidget(label_9, 0, 4, 1, 1);

        packDropBox = new QLabel(groupBox_2);
        packDropBox->setObjectName(QString::fromUtf8("packDropBox"));

        gridLayout_6->addWidget(packDropBox, 0, 3, 1, 1);

        label_7 = new QLabel(groupBox_2);
        label_7->setObjectName(QString::fromUtf8("label_7"));
        label_7->setAlignment(Qt::AlignRight|Qt::AlignTrailing|Qt::AlignVCenter);

        gridLayout_6->addWidget(label_7, 0, 0, 1, 1);

        uidBox = new QLabel(groupBox_2);
        uidBox->setObjectName(QString::fromUtf8("uidBox"));

        gridLayout_6->addWidget(uidBox, 0, 5, 1, 1);


        gridLayout_5->addLayout(gridLayout_6, 2, 1, 1, 1);


        gridLayout_3->addWidget(groupBox_2, 1, 0, 1, 1);

        tabWidget->addTab(tab, QString());
        tab_2 = new QWidget();
        tab_2->setObjectName(QString::fromUtf8("tab_2"));
        gridLayout_2 = new QGridLayout(tab_2);
        gridLayout_2->setSpacing(6);
        gridLayout_2->setContentsMargins(11, 11, 11, 11);
        gridLayout_2->setObjectName(QString::fromUtf8("gridLayout_2"));
        logTable = new QTableWidget(tab_2);
        if (logTable->columnCount() < 2)
            logTable->setColumnCount(2);
        QTableWidgetItem *__qtablewidgetitem = new QTableWidgetItem();
        __qtablewidgetitem->setText(QString::fromUtf8("Time"));
        logTable->setHorizontalHeaderItem(0, __qtablewidgetitem);
        QTableWidgetItem *__qtablewidgetitem1 = new QTableWidgetItem();
        __qtablewidgetitem1->setText(QString::fromUtf8("Message"));
        logTable->setHorizontalHeaderItem(1, __qtablewidgetitem1);
        logTable->setObjectName(QString::fromUtf8("logTable"));
        logTable->setAlternatingRowColors(true);
        logTable->setColumnCount(2);
        logTable->verticalHeader()->setVisible(false);

        gridLayout_2->addWidget(logTable, 0, 0, 1, 1);

        tabWidget->addTab(tab_2, QString());

        gridLayout->addWidget(tabWidget, 0, 0, 1, 1);

        MainWindow->setCentralWidget(centralWidget);
        menuBar = new QMenuBar(MainWindow);
        menuBar->setObjectName(QString::fromUtf8("menuBar"));
        menuBar->setGeometry(QRect(0, 0, 507, 22));
        menuFile = new QMenu(menuBar);
        menuFile->setObjectName(QString::fromUtf8("menuFile"));
        MainWindow->setMenuBar(menuBar);
        mainToolBar = new QToolBar(MainWindow);
        mainToolBar->setObjectName(QString::fromUtf8("mainToolBar"));
        MainWindow->addToolBar(Qt::TopToolBarArea, mainToolBar);
        statusBar = new QStatusBar(MainWindow);
        statusBar->setObjectName(QString::fromUtf8("statusBar"));
        MainWindow->setStatusBar(statusBar);
        QWidget::setTabOrder(tabWidget, logTable);

        menuBar->addAction(menuFile->menuAction());
        menuFile->addAction(actionClose);
        menuFile->addAction(actionOptions);

        retranslateUi(MainWindow);

        tabWidget->setCurrentIndex(0);


        QMetaObject::connectSlotsByName(MainWindow);
    } // setupUi

    void retranslateUi(QMainWindow *MainWindow)
    {
        MainWindow->setWindowTitle(QApplication::translate("MainWindow", "Waking Wind Receiver", 0, QApplication::UnicodeUTF8));
        actionClose->setText(QApplication::translate("MainWindow", "Close", 0, QApplication::UnicodeUTF8));
        actionOptions->setText(QApplication::translate("MainWindow", "Set Up", 0, QApplication::UnicodeUTF8));
        groupBox->setTitle(QApplication::translate("MainWindow", "Live Data", 0, QApplication::UnicodeUTF8));
        label_13->setText(QApplication::translate("MainWindow", "mm/h", 0, QApplication::UnicodeUTF8));
        label_12->setText(QApplication::translate("MainWindow", "%Rh", 0, QApplication::UnicodeUTF8));
        label_10->setText(QApplication::translate("MainWindow", "\302\260C", 0, QApplication::UnicodeUTF8));
        label_11->setText(QApplication::translate("MainWindow", "Km/h", 0, QApplication::UnicodeUTF8));
        label->setText(QApplication::translate("MainWindow", "<html><head/><body><p>Temperature:</p></body></html>", 0, QApplication::UnicodeUTF8));
        label_5->setText(QApplication::translate("MainWindow", "Rainfall:", 0, QApplication::UnicodeUTF8));
        label_4->setText(QApplication::translate("MainWindow", "Wind Direction:", 0, QApplication::UnicodeUTF8));
        label_3->setText(QApplication::translate("MainWindow", "Wind Speed:", 0, QApplication::UnicodeUTF8));
        label_2->setText(QApplication::translate("MainWindow", "<html><head/><body><p>Humidity:</p></body></html>", 0, QApplication::UnicodeUTF8));
        windsDegBox->setText(QApplication::translate("MainWindow", "0\302\260", 0, QApplication::UnicodeUTF8));
        wdBox->setText(QString());
        groupBox_2->setTitle(QApplication::translate("MainWindow", "Data Statistics", 0, QApplication::UnicodeUTF8));
        label_6->setText(QApplication::translate("MainWindow", "Data Quality:", 0, QApplication::UnicodeUTF8));
        label_8->setText(QApplication::translate("MainWindow", "Packets Dropped:", 0, QApplication::UnicodeUTF8));
        packetsRecvBox->setText(QApplication::translate("MainWindow", "0", 0, QApplication::UnicodeUTF8));
        label_9->setText(QApplication::translate("MainWindow", "Receiver UID:", 0, QApplication::UnicodeUTF8));
        packDropBox->setText(QApplication::translate("MainWindow", "0", 0, QApplication::UnicodeUTF8));
        label_7->setText(QApplication::translate("MainWindow", "Packets Recieved:", 0, QApplication::UnicodeUTF8));
        uidBox->setText(QApplication::translate("MainWindow", "0", 0, QApplication::UnicodeUTF8));
        tabWidget->setTabText(tabWidget->indexOf(tab), QApplication::translate("MainWindow", "Data", 0, QApplication::UnicodeUTF8));
        tabWidget->setTabText(tabWidget->indexOf(tab_2), QApplication::translate("MainWindow", "Log", 0, QApplication::UnicodeUTF8));
        menuFile->setTitle(QApplication::translate("MainWindow", "File", 0, QApplication::UnicodeUTF8));
    } // retranslateUi

};

namespace Ui {
    class MainWindow: public Ui_MainWindow {};
} // namespace Ui

QT_END_NAMESPACE

#endif // UI_MAINWINDOW_H
