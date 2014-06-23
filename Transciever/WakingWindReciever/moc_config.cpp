/****************************************************************************
** Meta object code from reading C++ file 'config.h'
**
** Created: Fri Jun 14 18:34:37 2013
**      by: The Qt Meta Object Compiler version 63 (Qt 4.8.2)
**
** WARNING! All changes made in this file will be lost!
*****************************************************************************/

#include "config.h"
#if !defined(Q_MOC_OUTPUT_REVISION)
#error "The header file 'config.h' doesn't include <QObject>."
#elif Q_MOC_OUTPUT_REVISION != 63
#error "This file was generated using the moc from 4.8.2. It"
#error "cannot be used with the include files from this version of Qt."
#error "(The moc has changed too much.)"
#endif

QT_BEGIN_MOC_NAMESPACE
static const uint qt_meta_data_Config[] = {

 // content:
       6,       // revision
       0,       // classname
       0,    0, // classinfo
       6,   14, // methods
       0,    0, // properties
       0,    0, // enums/sets
       0,    0, // constructors
       0,       // flags
       0,       // signalCount

 // slots: signature, parameters, type, tag, flags
       7,   39,   39,   39, 0x08,
      40,   39,   39,   39, 0x08,
      63,   90,   39,   39, 0x08,
      95,  118,   39,   39, 0x08,
     122,   39,   39,   39, 0x08,
     156,  195,   39,   39, 0x08,

       0        // eod
};

static const char qt_meta_stringdata_Config[] = {
    "Config\0on_testSettingsButton_clicked()\0"
    "\0onPortAddedOrRemoved()\0"
    "onPortNameChanged(QString)\0name\0"
    "onBaudRateChanged(int)\0idx\0"
    "on_testConnectionButton_clicked()\0"
    "on_buttonBox_clicked(QAbstractButton*)\0"
    "button\0"
};

void Config::qt_static_metacall(QObject *_o, QMetaObject::Call _c, int _id, void **_a)
{
    if (_c == QMetaObject::InvokeMetaMethod) {
        Q_ASSERT(staticMetaObject.cast(_o));
        Config *_t = static_cast<Config *>(_o);
        switch (_id) {
        case 0: _t->on_testSettingsButton_clicked(); break;
        case 1: _t->onPortAddedOrRemoved(); break;
        case 2: _t->onPortNameChanged((*reinterpret_cast< const QString(*)>(_a[1]))); break;
        case 3: _t->onBaudRateChanged((*reinterpret_cast< int(*)>(_a[1]))); break;
        case 4: _t->on_testConnectionButton_clicked(); break;
        case 5: _t->on_buttonBox_clicked((*reinterpret_cast< QAbstractButton*(*)>(_a[1]))); break;
        default: ;
        }
    }
}

const QMetaObjectExtraData Config::staticMetaObjectExtraData = {
    0,  qt_static_metacall 
};

const QMetaObject Config::staticMetaObject = {
    { &QDialog::staticMetaObject, qt_meta_stringdata_Config,
      qt_meta_data_Config, &staticMetaObjectExtraData }
};

#ifdef Q_NO_DATA_RELOCATION
const QMetaObject &Config::getStaticMetaObject() { return staticMetaObject; }
#endif //Q_NO_DATA_RELOCATION

const QMetaObject *Config::metaObject() const
{
    return QObject::d_ptr->metaObject ? QObject::d_ptr->metaObject : &staticMetaObject;
}

void *Config::qt_metacast(const char *_clname)
{
    if (!_clname) return 0;
    if (!strcmp(_clname, qt_meta_stringdata_Config))
        return static_cast<void*>(const_cast< Config*>(this));
    return QDialog::qt_metacast(_clname);
}

int Config::qt_metacall(QMetaObject::Call _c, int _id, void **_a)
{
    _id = QDialog::qt_metacall(_c, _id, _a);
    if (_id < 0)
        return _id;
    if (_c == QMetaObject::InvokeMetaMethod) {
        if (_id < 6)
            qt_static_metacall(this, _c, _id, _a);
        _id -= 6;
    }
    return _id;
}
QT_END_MOC_NAMESPACE
