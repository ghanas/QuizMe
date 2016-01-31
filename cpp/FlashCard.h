#include <iostream>
#include <cstdio>
#include <cstdlib>
#include <string>
#include <string.h>
#include <vector>
#include <fstream>
#include <dirent.h>
#include <sys/types.h>
using namespace std;


int menu();
//Gives the user a choice of all the options for 
//making flashcards.

void oneList();
//Runs through one flash card file - specified by
//the User.

void createList();
//Creates a new file for the user to use.

vector <int> randomize(int numarg);
//Randomzie the content of the vectors so that it simulates
//actual mixed up flashcards.

void FlashCard_write(vector <string>& R, vector <string>& D, vector <int>& N, int cond);
//Runs the actual part of the flashcard program. Enjoy!

void FlashCard_selfcheck(vector <string>& R, vector <string>& D, vector <int>& N);

void ListMe();
//Lists all the current .flash files in the current directory.

int flashMenu();
//Takes care of further choices offered when running flashcards.
