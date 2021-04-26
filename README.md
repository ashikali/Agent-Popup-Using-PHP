# Arabic number to Speech or Text

This is a small recursive ruby program which convert number to Playable format or Text format. 

## For example

If you call the function ar_number_to_voice with 4434 mentioned in the sample function call inside the number_to_arabic.rb file.

The output will be.

digits/4 digits/1000 digits/and digits/4 digits/100 digits/and digits/4 digits/and digits/30

in the WEB applications you can play corresponding sound files respectively.

## How to change the output format

if you want to change the format in case you want print as arabic text then inside the function 
         you can replace the digits/4 with 'أربعة'  
         you can replace the digits/1000 with 'ألف'
         you can replace the digits/and with 'و'
         you can replace the digits/100 with 'مائة' respectively.

## For the Asterisk IVR:

Find the say.conf file in Asterisk directory check the **[ar](digit-base)** context copy the context in your asterisk /etc/asterisk/say.conf
ensure reloaded the configuration
  
**In the php-agi, call as follows**

$agi->exec("PlayBack","num:{$info[0]},say");

**In the dialplan, call as**

playback(num:233123,say)

	

Hope you enjoyed.... :)


	  
         

