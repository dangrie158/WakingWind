/********************************************************************************
** Form generated from reading UI file 'config.ui'
**
** Created: Fri Jun 14 18:30:09 2013
**      by: Qt User Interface Compiler version 4.8.2
**
** WARNING! All changes made in this file will be lost when recompiling UI file!
********************************************************************************/

#ifndef UI_CONFIG_H
#define UI_CONFIG_H

#include <QtCore/QVariant>
#include <QtGui/QAction>
#include <QtGui/QApplication>
#include <QtGui/QButtonGroup>
#include <QtGui/QComboBox>
#include <QtGui/QDialog>
#include <QtGui/QDialogButtonBox>
#include <QtGui/QFormLayout>
#include <QtGui/QGridLayout>
#include <QtGui/QGroupBox>
#include <QtGui/QHeaderView>
#include <QtGui/QLabel>
#include <QtGui/QLineEdit>
#include <QtGui/QPushButton>

QT_BEGIN_NAMESPACE

class Ui_Config
{
public:
    QGridLayout *gridLayout;
    QGroupBox *groupBox;
    QFormLayout *formLayout;
    QLabel *label;
    QComboBox *portBox;
    QLabel *label_2;
    QComboBox *baudRateBox;
    QPushButton *testSettingsButton;
    QDialogButtonBox *buttonBox;
    QGroupBox *groupBox_2;
    QGridLayout *gridLayout_3;
    QLineEdit *userBox;
    QLineEdit *idBox;
    QLabel *label_4;
    QLineEdit *serverPortBox;
    QLineEdit *urlBox;
    QLabel *label_3;
    QLabel *label_5;
    QLineEdit *passwortBox;
    QLabel *label_6;
    QLineEdit *databaseBox;
    QLabel *label_7;
    QPushButton *testConnectionButton;

    void setupUi(QDialog *Config)
    {
        if (Config->objectName().isEmpty())
            Config->setObjectName(QString::fromUtf8("Config"));
        Config->resize(442, 395);
        Config->setModal(false);
        gridLayout = new QGridLayout(Config);
        gridLayout->setObjectName(QString::fromUtf8("gridLayout"));
        gridLayout->setSizeConstraint(QLayout::SetDefaultConstraint);
        groupBox = new QGroupBox(Config);
        groupBox->setObjectName(QString::fromUtf8("groupBox"));
        QSizePolicy sizePolicy(QSizePolicy::Preferred, QSizePolicy::Maximum);
        sizePolicy.setHorizontalStretch(0);
        sizePolicy.setVerticalStretch(0);
        sizePolicy.setHeightForWidth(groupBox->sizePolicy().hasHeightForWidth());
        groupBox->setSizePolicy(sizePolicy);
        formLayout = new QFormLayout(groupBox);
        formLayout->setObjectName(QString::fromUtf8("formLayout"));
        formLayout->setFieldGrowthPolicy(QFormLayout::ExpandingFieldsGrow);
        formLayout->setLabelAlignment(Qt::AlignRight|Qt::AlignTrailing|Qt::AlignVCenter);
        label = new QLabel(groupBox);
        label->setObjectName(QString::fromUtf8("label"));

        formLayout->setWidget(0, QFormLayout::LabelRole, label);

        portBox = new QComboBox(groupBox);
        portBox->setObjectName(QString::fromUtf8("portBox"));
        QSizePolicy sizePolicy1(QSizePolicy::Expanding, QSizePolicy::Fixed);
        sizePolicy1.setHorizontalStretch(0);
        sizePolicy1.setVerticalStretch(0);
        sizePolicy1.setHeightForWidth(portBox->sizePolicy().hasHeightForWidth());
        portBox->setSizePolicy(sizePolicy1);

        formLayout->setWidget(0, QFormLayout::FieldRole, portBox);

        label_2 = new QLabel(groupBox);
        label_2->setObjectName(QString::fromUtf8("label_2"));

        formLayout->setWidget(1, QFormLayout::LabelRole, label_2);

        baudRateBox = new QComboBox(groupBox);
        baudRateBox->setObjectName(QString::fromUtf8("baudRateBox"));
        QSizePolicy sizePolicy2(QSizePolicy::MinimumExpanding, QSizePolicy::Fixed);
        sizePolicy2.setHorizontalStretch(0);
        sizePolicy2.setVerticalStretch(0);
        sizePolicy2.setHeightForWidth(baudRateBox->sizePolicy().hasHeightForWidth());
        baudRateBox->setSizePolicy(sizePolicy2);

        formLayout->setWidget(1, QFormLayout::FieldRole, baudRateBox);

        testSettingsButton = new QPushButton(groupBox);
        testSettingsButton->setObjectName(QString::fromUtf8("testSettingsButton"));

        formLayout->setWidget(2, QFormLayout::LabelRole, testSettingsButton);


        gridLayout->addWidget(groupBox, 0, 0, 1, 1);

        buttonBox = new QDialogButtonBox(Config);
        buttonBox->setObjectName(QString::fromUtf8("buttonBox"));
        buttonBox->setOrientation(Qt::Horizontal);
        buttonBox->setStandardButtons(QDialogButtonBox::Cancel|QDialogButtonBox::Save);

        gridLayout->addWidget(buttonBox, 2, 0, 1, 1);

        groupBox_2 = new QGroupBox(Config);
        groupBox_2->setObjectName(QString::fromUtf8("groupBox_2"));
        gridLayout_3 = new QGridLayout(groupBox_2);
        gridLayout_3->setObjectName(QString::fromUtf8("gridLayout_3"));
        userBox = new QLineEdit(groupBox_2);
        userBox->setObjectName(QString::fromUtf8("userBox"));

        gridLayout_3->addWidget(userBox, 2, 2, 1, 1);

        idBox = new QLineEdit(groupBox_2);
        idBox->setObjectName(QString::fromUtf8("idBox"));

        gridLayout_3->addWidget(idBox, 4, 2, 1, 1);

        label_4 = new QLabel(groupBox_2);
        label_4->setObjectName(QString::fromUtf8("label_4"));
        label_4->setAlignment(Qt::AlignRight|Qt::AlignTrailing|Qt::AlignVCenter);

        gridLayout_3->addWidget(label_4, 2, 0, 1, 1);

        serverPortBox = new QLineEdit(groupBox_2);
        serverPortBox->setObjectName(QString::fromUtf8("serverPortBox"));
        QSizePolicy sizePolicy3(QSizePolicy::Expanding, QSizePolicy::Fixed);
        sizePolicy3.setHorizontalStretch(1);
        sizePolicy3.setVerticalStretch(0);
        sizePolicy3.setHeightForWidth(serverPortBox->sizePolicy().hasHeightForWidth());
        serverPortBox->setSizePolicy(sizePolicy3);

        gridLayout_3->addWidget(serverPortBox, 0, 3, 1, 1);

        urlBox = new QLineEdit(groupBox_2);
        urlBox->setObjectName(QString::fromUtf8("urlBox"));
        QSizePolicy sizePolicy4(QSizePolicy::Expanding, QSizePolicy::Fixed);
        sizePolicy4.setHorizontalStretch(3);
        sizePolicy4.setVerticalStretch(0);
        sizePolicy4.setHeightForWidth(urlBox->sizePolicy().hasHeightForWidth());
        urlBox->setSizePolicy(sizePolicy4);

        gridLayout_3->addWidget(urlBox, 0, 2, 1, 1);

        label_3 = new QLabel(groupBox_2);
        label_3->setObjectName(QString::fromUtf8("label_3"));
        label_3->setAlignment(Qt::AlignRight|Qt::AlignTrailing|Qt::AlignVCenter);

        gridLayout_3->addWidget(label_3, 0, 0, 1, 1);

        label_5 = new QLabel(groupBox_2);
        label_5->setObjectName(QString::fromUtf8("label_5"));
        label_5->setAlignment(Qt::AlignRight|Qt::AlignTrailing|Qt::AlignVCenter);

        gridLayout_3->addWidget(label_5, 3, 0, 1, 1);

        passwortBox = new QLineEdit(groupBox_2);
        passwortBox->setObjectName(QString::fromUtf8("passwortBox"));
        passwortBox->setEchoMode(QLineEdit::Password);

        gridLayout_3->addWidget(passwortBox, 3, 2, 1, 1);

        label_6 = new QLabel(groupBox_2);
        label_6->setObjectName(QString::fromUtf8("label_6"));
        QSizePolicy sizePolicy5(QSizePolicy::Preferred, QSizePolicy::Preferred);
        sizePolicy5.setHorizontalStretch(0);
        sizePolicy5.setVerticalStretch(0);
        sizePolicy5.setHeightForWidth(label_6->sizePolicy().hasHeightForWidth());
        label_6->setSizePolicy(sizePolicy5);
        label_6->setScaledContents(false);
        label_6->setAlignment(Qt::AlignRight|Qt::AlignTrailing|Qt::AlignVCenter);

        gridLayout_3->addWidget(label_6, 1, 0, 1, 1);

        databaseBox = new QLineEdit(groupBox_2);
        databaseBox->setObjectName(QString::fromUtf8("databaseBox"));

        gridLayout_3->addWidget(databaseBox, 1, 2, 1, 1);

        label_7 = new QLabel(groupBox_2);
        label_7->setObjectName(QString::fromUtf8("label_7"));
        label_7->setAlignment(Qt::AlignRight|Qt::AlignTrailing|Qt::AlignVCenter);

        gridLayout_3->addWidget(label_7, 4, 0, 1, 1);

        testConnectionButton = new QPushButton(groupBox_2);
        testConnectionButton->setObjectName(QString::fromUtf8("testConnectionButton"));

        gridLayout_3->addWidget(testConnectionButton, 5, 0, 1, 1);


        gridLayout->addWidget(groupBox_2, 1, 0, 1, 1);

        QWidget::setTabOrder(portBox, baudRateBox);
        QWidget::setTabOrder(baudRateBox, testSettingsButton);
        QWidget::setTabOrder(testSettingsButton, urlBox);
        QWidget::setTabOrder(urlBox, serverPortBox);
        QWidget::setTabOrder(serverPortBox, databaseBox);
        QWidget::setTabOrder(databaseBox, userBox);
        QWidget::setTabOrder(userBox, passwortBox);
        QWidget::setTabOrder(passwortBox, idBox);
        QWidget::setTabOrder(idBox, testConnectionButton);
        QWidget::setTabOrder(testConnectionButton, buttonBox);

        retranslateUi(Config);
        QObject::connect(buttonBox, SIGNAL(accepted()), Config, SLOT(accept()));
        QObject::connect(buttonBox, SIGNAL(rejected()), Config, SLOT(reject()));
        QObject::connect(buttonBox, SIGNAL(rejected()), Config, SLOT(reject()));

        QMetaObject::connectSlotsByName(Config);
    } // setupUi

    void retranslateUi(QDialog *Config)
    {
        Config->setWindowTitle(QApplication::translate("Config", "SetUp", 0, QApplication::UnicodeUTF8));
        groupBox->setTitle(QApplication::translate("Config", "Reciever", 0, QApplication::UnicodeUTF8));
        label->setText(QApplication::translate("Config", "Serial Port:", 0, QApplication::UnicodeUTF8));
        label_2->setText(QApplication::translate("Config", "Baud Rate:", 0, QApplication::UnicodeUTF8));
        testSettingsButton->setText(QApplication::translate("Config", "Test Setting", 0, QApplication::UnicodeUTF8));
        groupBox_2->setTitle(QApplication::translate("Config", "Server", 0, QApplication::UnicodeUTF8));
        userBox->setPlaceholderText(QApplication::translate("Config", "Username", 0, QApplication::UnicodeUTF8));
        idBox->setPlaceholderText(QApplication::translate("Config", "Location ID", 0, QApplication::UnicodeUTF8));
        label_4->setText(QApplication::translate("Config", "User:", 0, QApplication::UnicodeUTF8));
        serverPortBox->setPlaceholderText(QApplication::translate("Config", "Port (3306)", 0, QApplication::UnicodeUTF8));
        urlBox->setPlaceholderText(QApplication::translate("Config", "URL", 0, QApplication::UnicodeUTF8));
        label_3->setText(QApplication::translate("Config", "Server:", 0, QApplication::UnicodeUTF8));
        label_5->setText(QApplication::translate("Config", "Password:", 0, QApplication::UnicodeUTF8));
        passwortBox->setInputMask(QString());
        passwortBox->setPlaceholderText(QApplication::translate("Config", "Password", 0, QApplication::UnicodeUTF8));
        label_6->setText(QApplication::translate("Config", "Database:", 0, QApplication::UnicodeUTF8));
        databaseBox->setPlaceholderText(QApplication::translate("Config", "Database Name", 0, QApplication::UnicodeUTF8));
        label_7->setText(QApplication::translate("Config", "ID:", 0, QApplication::UnicodeUTF8));
        testConnectionButton->setText(QApplication::translate("Config", "Test Connection", 0, QApplication::UnicodeUTF8));
    } // retranslateUi

};

namespace Ui {
    class Config: public Ui_Config {};
} // namespace Ui

QT_END_NAMESPACE

#endif // UI_CONFIG_H
