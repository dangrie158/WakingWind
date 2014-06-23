#ifndef DATAOBJECT_H
#define DATAOBJECT_H
#include <QString>

class DataObject
{
public:
    DataObject();

    typedef enum {N = 0, NE = 2, E = 4, SE = 6, S = 8, SW = 10, W = 12, NW = 14} WindDir;

    void setTemperature( float temperature );
    void setHumidity( int humidity );
    void setWindspeed( float windspeed );
    void setWinddir( WindDir winddir );
    void setRainfall( float rainfall );
    void setBatData( unsigned int batdata );
    void setUID ( unsigned int uid );
    void setChecksum( QString chksum );

    float temperature();
    int humidity();
    float windspeed();
    DataObject::WindDir winddir();
    float rainfall();
    unsigned int batdata();
    unsigned int uid();
    QString checksum();

private:
    float m_fTemperature;
    int m_iHumidity;
    float m_fWindspeed;
    DataObject::WindDir m_wWinddir;
    float m_fRainfall;
    unsigned int m_uiBatdata;
    unsigned int m_sUid;
    QString m_sChecksum;
};

#endif // DATAOBJECT_H
