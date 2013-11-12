# Paint Something!

## Table of contents

* <a href="#projects-goal">Project's goal</a>
* <a href="#tasks-identification">Tasks' identification</a>
* <a href="#planification">Planification</a>

## Project's goal

The project's goal is to realize a website containing a game based on the popular mobile phone "<a href="http://en.wikipedia.org/wiki/Draw_Something">Draw something</a>" application, based on the "<a href="http://en.wikipedia.org/wiki/Pictionary">Pictionnary</a>" guessing word game itself.

The game's progression is pretty simple:

1. the game requires 2 or more players to start;
2. in rotation, one of the players becomes "designer";
3. the game gives the designer one word haphazarldy;
4. the designer must draw a representation of the given word;
5. remaining players must guess the word with the drawing (in a limited amount of attemps).

The game's winner is the one who scores the most points. There is 2 manners to win points:

1. as a designer: one of the remaining players guess the word (+ X points);
2. as a non-designer: guess the word (+ X * 5 points).

The game ends after some turns (1 turn means everyone was 1 time designer) or when a player got a points' threshold.

## Tasks' identification

According to the general planification:

* creation of the base HTML (including CSS) code's skeleton: login, menus and gamescreen's pages;
* creation of a simple paint program based on canvas (Javascript);
* creation of the database (using Zend framework);
* implements pages' dynamics (forms actions and treatments, game's timers);
* unit and integration tests.

## Planification

### General planification

<img src="https://raw.github.com/theragebox/paint_something/master/documentation/general-planification.png" />

### Human resources

<table>
  <thead>
    <th>Firstname</th>
    <th>Lastname</th>
    <th>Worktime</th>
  </thead>
  <tr>
    <td>Dany</td>
    <td>Jupille</td>
    <td>8 * 45' per week</td>
  </tr>
  <tr>
    <td>Etienne</td>
    <td>Frank</td>
    <td>8 * 45' per week</td>
  </tr>
  <tr>
    <td>Mirco</td>
    <td>Nasuti</td>
    <td>8 * 45' per week</td>
  </tr>
</table>

### Final planification

<table>
  <thead>
    <th>State</th>
    <th>Task</th>
    <th>Worker</th>
    <th>Accorded time</th>
  </thead>
  <tr>
    <td>On work</td>
    <td>Creation of the base HTML...</td>
    <td>Dany Jupille</td>
    <td>3 weeks (24 * 45')</td>
  </tr>
  <tr>
    <td>On work</td>
    <td>Creation of a simple paint...</td>
    <td>Mirco Nasuti</td>
    <td>3 weeks (24 * 45')</td>
  </tr>
  <tr>
    <td>On work</td>
    <td>Creation of the database...</td>
    <td>Etienne Frank</td>
    <td>3 weeks (24 * 45')</td>
  </tr>
</table>
