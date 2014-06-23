#-------------------------------------------------
#
# Project created by QtCreator 2013-05-04T21:21:45
#
#-------------------------------------------------

include(3rdparty/qextserialport/src/qextserialport.pri)

QT       += core gui sql

greaterThan(QT_MAJOR_VERSION, 4): QT += widgets

TARGET = WakingWindReciever
TEMPLATE = app


SOURCES += main.cpp\
        mainwindow.cpp \
    config.cpp \
    connectionchecker.cpp \
    dataobject.cpp

HEADERS  += mainwindow.h \
    config.h \
    connectionchecker.h \
    dataobject.h

FORMS    += mainwindow.ui \
    config.ui \
    connectionchecker.ui

RESOURCES += \
    res.qrc
