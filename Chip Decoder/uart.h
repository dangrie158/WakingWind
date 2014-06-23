
#ifndef _SOFT_UART_H_
#define _SOFT_UART_H_

#include <avr/io.h>
#include <avr/interrupt.h>


#define WAIT_UNTIL_BYTE_SENT    1      	// wait until byte sent before returning when calling the sendByte() function
#define PACKETDELAY             10      // null bits to sent between each byte sent
#define BAUD                    208     // baud rate 38400
#define NUMBITS 				175		//Number of bits we want to send
//   BAUD FORMULA	baud rate value = ((IO CLK/PRESCALER)/1000000)*(1000000/BAUD)
//   PRESCALER:  The timer prescaler setting
//   IO CLK:     NOT F_CPU, INTERNAL OSCILATOR e.g.. 4000000 MHZ, 8000000 MHZ or 9600000 MHZ

volatile uint8_t 				bit;	//current bit in byte
volatile unsigned char 			byt;	//byte to send

void uartInit();						//SetUp Timer and Initialize other Stuff
void sendByte( char byte );				//Send one Byte
void sendByteArray( char* bytes );		//Send a NULL terminated Byte Array



#endif