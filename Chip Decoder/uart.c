#include "uart.h"

ISR( TIM1_COMPA_vect )
{
														// START BIT
	if( !bit )
	{
		PORTB &= ~( 1 << PB0 ); 						// START BIT IS HIGH
		bit++;
	}
	else if( bit < 9 )
	{
														//DATA BITS
		if((byt & 0b00000001)){  						//test left most bit
			PORTB |= 1 << PB0;  						//TXPIN HIGH
		} else {
			PORTB &= ~( 1 << PB0 ); 					//TXPIN LOW
		}

		byt >>= 1;
		bit++;
	} else {
														//STOP BIT
		PORTB |= 1 << PB0;  							//STOP BIT IS HIGH

		if( bit == ( PACKETDELAY + 8 ) ){ 				// TIME BETWEEN BYTES SENT
			return; 									//return, All data is sent
		} else {
			bit++;
		}
	}
}

void uartInit()
{
	bit = ( PACKETDELAY + 8 ); 							//start stopped
	byt = 0;
	DDRB |= 1 << PB0;   								//Set TXPIN/PORT to output. 
	PORTB |= 1 << PB0;									//Enable internal PullUp on PTXPIN
	TCCR1 |= 1 << CTC1;     							//Clear Timer/Counter on Compare Match
	TCCR1 |= 1 << CS10;     							//Prescaller = 1      
	OCR1C = BAUD;										//Overflow Timer/Compare
	TCNT1 = 0;											//Just set it to check the right bits are set
	TIMSK |= 1<<OCIE1A;									//Enable Interupt on Compare
}

void sendByte( char byte )
{
	while( !( bit == ( PACKETDELAY + 8 ) ) ){} 			//wait/verify current byte sent

	byt = byte; 										//load buffer
	bit = 0;

	while( !( bit == ( PACKETDELAY + 8 ) ) ){} 			//wait until current byte sent 
}

void sendByteArray( char* bytes )
{
	int i;
	for( i=0; i<NUMBITS; i++ )							//While not Terminated
	{
		sendByte( bytes[i] );							//Send our Byte
	}
}