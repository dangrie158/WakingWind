#include "main.h"

int main(void)
{
	sampleCounter=0;
	numBitsRecieved=0;
	currentBit=0;

	DDRB |= 1 << PB1;									//PB1 is output
	DDRB |= 1 << PB3;									//PB3 is output
	DDRB &= ~(1 << PB2);								//PB2 is input
	PORTB |= 1 << PB2;									//Enable internal PullUp for PB2

	GIMSK |= 1 << PCIE;									// Enable pin change interrupt for PORTB 
	PCMSK |= 1 << PCINT2;								// Enable pin change interrupt for PB2
	MCUCR |= 1 << ISC00;								// Enable Interrupt Internet Sense Control
	MCUCR &= ~(1 << ISC01);								// Enable Interrupt Internet Sense Control

	TCCR0B |= 1 << CS01;								//Prescaling 8
	TCCR0A |= 1 << WGM01;								//CTC Mode						
	OCR0A = 0x17;										//Overflow at ~23 µS @ 1MHz
	TCNT0 = 0x00;										//Just to be sure
	TIMSK |= (1<<OCIE0A);								//Enable Interrupt on match OCR0A


	uartInit();											//Initialize the Softwar UART
	sei();												//Enable our global Interrupts

	PORTB &= ~( 1 << PB1 );								//Switch off green LED
	PORTB &= ~( 1 << PB3 );								//Switch off red LED

	while(1)
	{
		if( needsending )
		{
			PORTB |= 1 << PB3;							//Switch on red LED

			for( currentBit=0; currentBit < NUMBITS; currentBit++ )	//For each bit we have
			{
				if( timedata[currentBit] > 27 && timedata[currentBit] <= 55 )
				{
					timedata[currentBit] = 'n';			//This was a pause in our PWM
				}
				else if( timedata[currentBit] > 55 && timedata[currentBit] <= 80 )
				{
					timedata[currentBit] = '0';			//This was a logical 0 in our PWM
				}
				else if( timedata[currentBit] > 0 && timedata[currentBit] <= 27 )
				{
					timedata[currentBit] = '1';			//This was a logical 1 in our PWM
				}
			}
			sendByteArray( (char*)timedata );			//Send the Bits
			sendByte( '\n');							//newline
			sendByte( '\r' );							//carriage return
			needsending = false;						//we're ready sending

			PORTB &= ~( 1 << PB3 );						//Switch off red LED
		}
	}
}

ISR( PCINT0_vect )
{
	if(!needsending)									//while we're not sending
	{
		timedata[numBitsRecieved++] = sampleCounter;	//Safe the number of Samples
		if( numBitsRecieved >= NUMBITS )				//did we recieve enough bits?
		{
			numBitsRecieved=0;							//start over
			needsending = true;							//but send the whole stuff first
		}
		sampleCounter=0;								//reset the sample counter

		PORTB ^= 1 << PB1;								//LED Toggle
	}						
}

ISR( TIMER0_COMPA_vect )
{
	sampleCounter++;
	if( sampleCounter > 80 )							//Timeout this is not the Signal you are looking for
	{
		numBitsRecieved = 0;							//Reset
		currentBit = 0;									//the whole
		sampleCounter = 0;								//state
	}
}