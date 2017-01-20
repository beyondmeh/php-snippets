# php-snippets
*Fun programming exercises for entertainment*

These are various PHP scripts I have written over the years for my sole enjoyment.

## Scripts:

* [base58.php](#base58)
* [bofh.php](#bofh)
* [deadfish.php](#deadfish)
* crypto/
    * [ceaser.php](#ceaser)
    * [keyed_fibonacci.php](#fibonacci)
    * [oauth.php](#oauth)
    * [vigenere.php](#vigenere)
* [genprimes.php](#genprimes)
* [greeting.php](#greeting)
* images/
    * [img2html.php](#img2html)
    * [txt2img.php](#txt2img)
* [morse.php](#morse)
* [music.php](#music)
* [reddit-rss.php](#reddit-rss)


## Script Descriptions

### `base58.php`
<a name="base58"></a>
Functions to [Base58](https://en.wikipedia.org/wiki/Base58) large integers into
a string that excludes similar looking characters (O, 0, 1, l, etc). The
conversion alphabet is the same used in [Bitcoin](https://en.bitcoin.it/wiki/Base58Check_encoding).

### `bofh.php`
<a name="bofh"></a>
Generates a random [Bastard Operator from Hell](https://en.wikipedia.org/wiki/Bastard_Operator_From_Hell)
calendar excuse. Probably the most useful and applicable script you will ever find.

### `deadfish.php`
<a name="deadfish"></a>
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
```
php deadfish.php  
>> iiiio  
4  
>> d  
3  
```

###### Passing a command string directly:
```
php deadfish.php iisiiiis{ic}{ic}icicicicicic
ABCDEFGHIJKLMNOPQRSTUVWXYZ
```

### `ceaser.php`
<a name="ceaser"></a>
A PHP implementation of a shift cipher, which is what the classic Caesar and ROT13
ciphers are. This script doesn't rotate the characters using their ASCII values,
so it's compatible with the standard pen and paper method. At the same time that
means non *A-Z* characters are ignored.

### `genprimes.php`
<a name="genprimes"></a>
Efficiently, *as one can using PHP*, generate prime numbers with the ability to
start where you left off last run.

### `greeting.php`
<a name="greeting"></a>
Using [eSpeak](http://espeak.sourceforge.net/), say an appropriate greeting for
the current time with a random saying from the movie [WarGames](http://www.imdb.com/title/tt0086567/).
Good for impressing others when set to run at startup.

### `img2html.php`
<a name="img2html"></a>
A proof of concept to convert an image into a HTML table with colored cells as
the pixels. Note this is super slow and tends to freeze the browser until the
table is completely rendered.

### `keyed_fibonacci.php`
<a name="fibonacci"></a>
A [Polyalphabetic Cipher](https://en.wikipedia.org/wiki/Polyalphabetic_cipher)
using a [lagged Fibonacci generator](https://en.wikipedia.org/wiki/Lagged_Fibonacci_generator).
The generator is seeded with a given password, which in turn is used to generate
a number for each letter of the message. That number is then used to rotate each
letter of the message.

For a pen and paper cipher, this method is more secure than the other ciphers,
with the lagged generator defeating frequency analysis. The length of the password
directly effects the cipher's complexity.

### `morse.php`
<a name="morse"></a>
Plays morse code through the speaker, taking a message to convert in quotes as an
argument.

If you simply want a script to convert a character to morse code, look at the
function `char2morse()` and loop each character of a string to it.

### `music.php`
<a name="music"></a>
Pass a preset song title as an argument to have it played through the speakers
entirely using PHP (no other programs are used). The "music" is nothing more
than a string of frequencies and durations.

`note()` computes the frequency of a piano key given it's distance from middle C.
For example, A would be -2 and F would be 5. You can go up and down multiple
octaves too... just add or subtract 8 from the note you want.

#### Usage:
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

### `oauth.php`
<a name="oauth"></a>
Example of a [TOTP](https://en.wikipedia.org/wiki/Time-based_One-time_Password_Algorithm)
implementation in PHP, which could be used for OAUTH or two-factor authentication.

### `reddit-rss.php`
<a name="reddit-rss"></a>
Parses a [Reddit](http://reddit.com) RSS feed and returns an array with the title,
link, and content teaser for every entry in the feed. Also includes a function to
convert said array into a HTML list.

*I was going to do something more with this, but I lost interest... maybe it will
be of use to someone else.*

### `txt2img.php`
<a name="txt2img"></a>
Converts plain text into a pixelated image with each pixel representing the binary
value of each ASCII character in the message.

### `vigenere.php`
<a name="vigenere"></a>
*An implementation of a [Vigenère cipher](https://en.wikipedia.org/wiki/Vigen%C3%A8re_cipher)*

This is a pen and paper compatible version of the Vigenère cipher, therefore non
*A-Z* characters are ignored. Per the original, the password is repeated until
it's length matches the message length, so a longer password is more secure.

A Vigenère square / tabula recta is not needed, as the encoding is done on the fly.


## Usage
All shell scripts include a help command that can be invoked by passing the `-h`
flag to them. This will print a brief explanation of what the script does as well
as the usage and any flags or options that can be set.


## Feedback
I would love your feedback! If you found any of these snippets useful, please
drop me [an email](mailto:timothykeith@gmail.com). For the privacy conscious,
feel free to encrypt any messages using my [PGP key](http://pgp.mit.edu/pks/lookup?op=vindex&fingerprint=on&search=0xF4F4A135C022EE12):

> 4135 C593 1D89 368E 7F32 C8ED F4F4 A135 C022 EE12

To import it into your keyring:
```console
$  gpg --keyserver pgp.mit.edu --recv-key 4135C5931D89368E7F32C8EDF4F4A135C022EE12
```

Submit bug reports via GitHub's [Issue Tracker](https://github.com/keithieopia/php-snippets/issues)


## Author
Copyright &copy; 2016 - 2017 Timothy Keith

Licensed under the [MIT license](https://github.com/keithieopia/php-snippets/blob/master/LICENSE).

*This is free software: you are free to change and redistribute it. There is NO
WARRANTY, to the extent permitted by law.*
