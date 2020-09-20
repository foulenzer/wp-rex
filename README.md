# wp-rex
Your wordpress got hacked?  
This simple tool helps you to find malicious code in your wordpress installation. 

## Installation
Just clone this repo and move following files into your wordpress root directory:
- wp-rex-checksum.php
- wp-rex-detector  

## Usage
- `php wp-rex-checksum.php`
- `./wp-rex-detector DAYS` (DAYS = check changed file for the last X days - default: 7)
