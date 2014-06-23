#include "dataobject.h"

DataObject::DataObject() :
	m_fTemperature( 0.0f ),
	m_fRainfall( 0.0f ),
	m_iHumidity( 0.0f ),
	m_fWindspeed( 0.0f ),
	m_wWinddir( DataObject::N )
{
}

void DataObject::setTemperature( float temperature )
{
m_fTemperature = temperature;
}

void DataObject::setHumidity( int humidity )
{
    m_iHumidity = humidity;
}

void DataObject::setWindspeed( float windspeed )
{
    m_fWindspeed = windspeed;
}

void DataObject::setWinddir( WindDir winddir )
{
    m_wWinddir = winddir;
}

void DataObject::setRainfall( float rainfall )
{
    m_fRainfall = rainfall;
}

void DataObject::setBatData( unsigned int batdata )
{
   m_uiBatdata = batdata;
}

void DataObject::setUID ( unsigned int uid )
{
    m_sUid = uid;
}

void DataObject::setChecksum( QString chksum )
{
    m_sChecksum = chksum;
}

float DataObject::temperature()
{
    return m_fTemperature;
}

int DataObject::humidity()
{
    return m_iHumidity;
}

float DataObject::windspeed()
{
    return m_fWindspeed;
}

DataObject::WindDir DataObject::winddir()
{
    return m_wWinddir;
}

float DataObject::rainfall()
{
    return m_fRainfall;
}

unsigned int DataObject::batdata()
{
    return m_uiBatdata;
}

unsigned int DataObject::uid()
{
    return m_sUid;
}

QString DataObject::checksum()
{
    return m_sChecksum;
}
