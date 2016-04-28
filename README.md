# snippets
*Fun programming exercises for entertainment*


## Synopsis
These are various PHP scripts I have written over the years for my sole enjoyment.

### Scripts:


#### `bofh.php`
Generates a random [Bastard Operator from Hell](https://en.wikipedia.org/wiki/Bastard_Operator_From_Hell) 
calendar excuse. Probably the most useful and applicable script you will ever find. 


#### `deadfish.php`

Deadfish is a joke programming language I found on the 
[esoteric programming language wiki](http://www.esolangs.org/). After quickly 
writing an interpreter for it in PHP, I set out to implement [Deadfish~](http://esolangs.org/wiki/Deadfish%7E), 
it's successor. As far as I know, I'm the first to write one in PHP... *so I have that going for me.*

##### Operations:
|cmd| Description                                                          |  Version   |  
|:-:|:---------------------------------------------------------------------|:-----------:  
| i | This increments the accumulator                                      |  Deadfish  |  
| d | This decrements the accumulator                                      |  Deadfish  |  
| s | Squares the value in the accumulator                                 |  Deadfish  |  
| o | Outputs the accumulator                                              |  Deadfish  |  
| h | Halt                                                                 | *see note* |
| c | Print the accumulator's equivalent ASCII character                   | Deadfish~  |  
| {}| Instructions inside the curly braces loop ten times                  | Deadfish~  |  
| ()| If the accumulator is not zero, execute the instructions inside once | Deadfish~  |
| w | Hello, World! greeting is displayed                                  | Deadfish~  |

**Note**: Some implementations of Deadfish include the `h` command, however it was 
only officially added in Deadfish~

##### Sample programs:

###### Running the interactive CLI:
```php deadfish.php  
>> iiiio  
4  
>> d  
3  
```

###### Passing a command string directly:
```php deadfish.php iisiiiis{ic}{ic}icicicicicic
ABCDEFGHIJKLMNOPQRSTUVWXYZ
```

 
#### `crypto/ceaser.php`
A PHP implementation of a shift cipher, which is what the classic Caesar and ROT13 
ciphers are. This script doesn't rotate the characters using their ASCII values, 
so it's compatible with the standard pen and paper method. At the same time that 
means non *A-Z* characters are ignored.


#### `keyed_fibonacci.php`
*A [Polyalphabetic Cipher](https://en.wikipedia.org/wiki/Polyalphabetic_cipher) 
using a [lagged Fibonacci generator](https://en.wikipedia.org/wiki/Lagged_Fibonacci_generator).*

A lagged Fibonacci generator is seeded with a given password, which in turn is 
used to generate a number for each letter of the message. That number is then used 
to rotate each letter of the message.

For a type of Polyalphabetic Cipher, this method is more secure than the other 
algorithms, with the lagged generator defeating frequency analysis. The length of 
the password directly effects the cipher's complexity.

#### `vigenere.php`
*An implementation of a [Vigenère cipher](https://en.wikipedia.org/wiki/Vigen%C3%A8re_cipher)*

This is a pen and paper compatible version of the Vigenère cipher, therefore non 
*A-Z* characters are ignored. Per the original, the password is repeated until 
it's length matches the message length, so a longer password is more secure.

A Vigenère square / tabula recta is not needed, as the encoding is done on the fly.
 

#### `genprimes.php`
Efficiently, *as one can using PHP*, generate prime numbers with the ability to 
start where you left off last run.


#### `greeting.php`
Using [eSpeak](http://espeak.sourceforge.net/), say an appropriate greeting for 
the current time with a random saying from the movie [WarGames](http://www.imdb.com/title/tt0086567/). 
Good for impressing others when set to run at startup.


#### `images/img2html.php`
A proof of concept to convert an image into a HTML table with colored cells as 
the pixels. Note this is super slow and tends to freeze the browser until the 
table is completely rendered.


#### `images/txt2img.php`
Converts plain text into a pixelated image with each pixel representing the binary 
value of each ASCII character in the message.


#### `morse.php`
Plays morse code through the speaker, taking a message to convert in quotes as an 
argument.

If you simply want a script to convert a character to morse code, look at the 
function `char2morse()` and loop each character of a string to it.


#### `music.php`
Pass a preset song title as an argument to have it played through the speakers 
entirely using PHP (no other programs are used). The "music" is nothing more 
than a string of frequencies and durations.

`note()` computes the frequency of a piano key given it's distance from middle C. 
For example, A would be -2 and F would be 5. You can go up and down multiple 
octaves too... just add or subtract 8 from the note you want.

##### Usage:
* `music.php scale` - Plays a musical scale
* `music.php gentlemen` - "God Rest Ye Merry Gentlemen", a Christmas carol
* `music.php deckhalls` - "Deck the Halls" a Christmas carol    
* `music.php entertainer` - "The Entertainer" by Joplin
* `music.php bumblebee` - "Flight of the Bumblebee" by Nikolai Rimsky
* `music.php crazytrain` - "Crazy Train" by Ozzy Osbourne
* `music.php movitit` - "I Like to Move It" by Reel 2 Real
* `music.php clocks` - "Clocks" by Coldplay
* `music.php empire` - The Imperial March from the movie series, Star Wars
* `music.php pinkpanther` - The Pink Panther Theme song from the cartoon and movies
* `music.php ffvictory` - Victory fanfare from the game series, "Final Fantasy"
* `music.php mario` - Underwater theme from the game, "Super Mario Bros"
* `music.php stillalive` - "Still Alive" from the game, "Portal"


#### `reddit-rss.php`
Parses a [Reddit](http://reddit.com) RSS feed and returns an array with the title, 
link, and content teaser for every entry in the feed. Also includes a function to 
convert said array into a HTML list.

*I was going to do something more with this, but I lost interest... maybe it will
be of use to someone else.*


## Usage
All shell scripts include a help command that can be invoked by passing the `-h`
flag to them. This will print a brief explanation of what the script does as well 
as the usage and any flags or options that can be set.


## Feedback
I would love your feedback! If you found any of the scripts in this git repo useful, 
please drop me [an email](mailto:timothykeith@gmail.com).

Submit bug reports via GitHub's [Issue Tracker](https://github.com/keithieopia/snippets/issues)


## Author
Copyright &copy; 2016 Timothy Keith

License: The BSD 2-Clause License, see [LICENSE](https://raw.githubusercontent.com/keithieopia/snippets/master/LICENSE)

_This is free software: you are free to change and redistribute it._
_There is NO WARRANTY, to the extent permitted by law._
