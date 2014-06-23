#include <inttypes.h>
#include <avr/io.h>
#include <avr/interrupt.h>
#include <util/delay.h>
#include <stdbool.h>

#include "uart.h"

#define F_CPU 			8000000UL  			// 8 MHz IOClk

#define NUMBITS 		175					//Number of bits we want to recieve

volatile uint8_t 		sampleCounter,		//number of samples between edges of signal (1 sample -> 23µS)
						numBitsRecieved, 	//current number of bits recieved
						currentBit;			//current bit in conversion
volatile uint8_t 		timedata[NUMBITS];	//our non-buffered Array
volatile bool 			needsending;		//to store whether we're ready recieving/sending or not
