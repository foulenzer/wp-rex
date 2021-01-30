![Image of Rex](https://www.wisst-ihr-noch.de/wp-content/uploads/2017/02/kommissar-rex.jpg)
# wp-rex
Your wordpress got hacked?  
This simple tool helps you to find malicious code in your wordpress installation. 

PLEASE BE AWARE: This script is new and will be pointing out lots of false positives. Please check all the findings manually!
Feel free to send me wordpress malware samples: [Ben](mailto:samples@foulenzer.me)

![Image of example output](https://foulenzer.me/wp-rex.png)

## Installation
Just clone this repo and move following files into your wordpress root directory:
- wp-rex.php
- wp-rex-shell

## Usage

### Web access
If there is no redirect (e.g. in the .htaccess-file or via malware) and you can reach your wordpress blog as usual:
- visit `https://url-to-your-wordpress-blog.tld/wp-rex.php`

### Command line access
If you do not have web access to your blog, connect to your webspace/server via the command line / SSH and navigate to your wordpress root-directory. Then execute following command:
- `./wp-rex-detector DAYS` (DAYS = check changed files for the last X days - default: 7)

## To-Do
- [x] all-in-one script via url-access
- [x] removed "md5" from search expressions (thx to @felsqualle)
- [x] new regex
- [x] implemented correct modification changes to php-file
- [ ] add new regexes on a regular basis
- [ ] check for bad file permissions?
- [ ] more cool features (send me a feature request @foulenzer)