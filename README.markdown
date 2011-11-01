FYShuffle
=========

http://github.com/robvanbentem/FYShuffle

A Fisher-Yates shuffle PHP implementation. (http://en.wikipedia.org/wiki/Fisher-Yates_shuffle)


Usage
-----

FYShuffle has two 'working modes'

+ range - this mode returns integers within a certain range.
+ array - returns elements from a user provided array.

### Range mode ###

In range mode you must provide a `min` and `max` value to the ctor.

  ``$shuffle = new FYShuffle(1, 10);``

You now have created a simple shufflebag with ten values in it. It's like putting ten numbers in a hat. 
The next thing to do is `fetch` a value from the bag (pick a number from the hat!):

  ``$randomNum = $shuffle->fetch();``

This will return a random value from the 'bag'. Because FYShuffle is a shufflebag, the chosen value will not be picked again until all other values are picked once.

When all the values are picked, we reset the bag (we fill the bag with all the values again) and we start picking random values again.

### Array mode ###

In array mode you can provide your own `array` with element.
You simply pass you `array` to the ctor:

  ``$alphabet = range('a', 'z');
  $shuffle = new FYShuffle($alphabet);``

After that you can `fetch` a random element the same way is in range mode:

  ``$randomChar = $shuffle->fetch();``

Like range mode, when all elements are picked, the bag gets reset again.


Why is this useful?
-------------------

The Fisher-Yates method provides an efficient way of picking non repeating numbers from a range.

This can be usefull when:

+ You want to pick alot of unique random numbers and performance is an issue.
+ A user has n amount of images on his profile page and they must be displayed in random order.
+ You are creating a 'match it' game and the cards must be displayed randomly on the board.

Of course you can do the checking for doubles yourself, but why would you? ;)

