/********************************************************************************
** Form generated from reading UI file 'connectionchecker.ui'
**
** Created: Fri Jun 14 18:30:10 2013
**      by: Qt User Interface Compiler version 4.8.2
**
** WARNING! All changes made in this file will be lost when recompiling UI file!
********************************************************************************/

#ifndef UI_CONNECTIONCHECKER_H
#define UI_CONNECTIONCHECKER_H

#include <QtCore/QVariant>
#include <QtGui/QAction>
#include <QtGui/QApplication>
#include <QtGui/QButtonGroup>
#include <QtGui/QDialog>
#include <QtGui/QGridLayout>
#include <QtGui/QHeaderView>
#include <QtGui/QLabel>
#include <QtGui/QProgressBar>
#include <QtGui/QPushButton>
#include <QtGui/QSpacerItem>
#include <QtGui/QWidget>

QT_BEGIN_NAMESPACE

class Ui_ConnectionChecker
{
public:
    QGridLayout *gridLayout;
    QProgressBar *statusBar;
    QWidget *widget;
    QGridLayout *gridLayout_2;
    QPushButton *cancelButton;
    QLabel *statusLabel;
    QSpacerItem *horizontalSpacer;

    void setupUi(QDialog *ConnectionChecker)
    {
        if (ConnectionChecker->objectName().isEmpty())
            ConnectionChecker->setObjectName(QString::fromUtf8("ConnectionChecker"));
        ConnectionChecker->setWindowModality(Qt::WindowModal);
        ConnectionChecker->resize(306, 94);
        gridLayout = new QGridLayout(ConnectionChecker);
        gridLayout->setObjectName(QString::fromUtf8("gridLayout"));
        statusBar = new QProgressBar(ConnectionChecker);
        statusBar->setObjectName(QString::fromUtf8("statusBar"));
        statusBar->setValue(24);
        statusBar->setTextVisible(false);
        statusBar->setInvertedAppearance(false);

        gridLayout->addWidget(statusBar, 0, 0, 1, 1);

        widget = new QWidget(ConnectionChecker);
        widget->setObjectName(QString::fromUtf8("widget"));
        gridLayout_2 = new QGridLayout(widget);
        gridLayout_2->setObjectName(QString::fromUtf8("gridLayout_2"));
        cancelButton = new QPushButton(widget);
        cancelButton->setObjectName(QString::fromUtf8("cancelButton"));

        gridLayout_2->addWidget(cancelButton, 0, 2, 1, 1);

        statusLabel = new QLabel(widget);
        statusLabel->setObjectName(QString::fromUtf8("statusLabel"));

        gridLayout_2->addWidget(statusLabel, 0, 0, 1, 1);

        horizontalSpacer = new QSpacerItem(40, 20, QSizePolicy::Expanding, QSizePolicy::Minimum);

        gridLayout_2->addItem(horizontalSpacer, 0, 1, 1, 1);


        gridLayout->addWidget(widget, 1, 0, 1, 1);


        retranslateUi(ConnectionChecker);
        QObject::connect(cancelButton, SIGNAL(clicked()), ConnectionChecker, SLOT(close()));

        QMetaObject::connectSlotsByName(ConnectionChecker);
    } // setupUi

    void retranslateUi(QDialog *ConnectionChecker)
    {
        ConnectionChecker->setWindowTitle(QApplication::translate("ConnectionChecker", "Checking Connection", 0, QApplication::UnicodeUTF8));
        cancelButton->setText(QApplication::translate("ConnectionChecker", "Cancel", 0, QApplication::UnicodeUTF8));
        statusLabel->setText(QApplication::translate("ConnectionChecker", "No Service", 0, QApplication::UnicodeUTF8));
    } // retranslateUi

};

namespace Ui {
    class ConnectionChecker: public Ui_ConnectionChecker {};
} // namespace Ui

QT_END_NAMESPACE

#endif // UI_CONNECTIONCHECKER_H
