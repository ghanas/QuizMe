#include "FlashCard.h"
using namespace std;


int menu()
{
  int cond, answer;

  cond = 1;


  printf("Welcome to FlashCard!\n");

  while (cond == 1)
  {
    printf("Please make a choice from the following menu:\n");
    printf("1. Create a new flashcard list.\n");
    printf("2. Select a list to go through\n");
    printf("3. Go through all of the lists\n");
    printf("4. Read the instructions for this program.\n");

    cin >> answer;
    if (answer <= 0 || answer >= 5)
      printf("An invalid choice (%d) has been made.\n", answer);
    else
      cond = 0;
  }

  return answer;
}

void oneList()
{
  int size;
  int i;
  string filename;
  string tmp1;
  string tmp2;
  ifstream fout;
  vector <string> Romanji;
  vector <string> Definition;
  vector <int> Random;


  i = 0;
  printf("Please give the file name for the program to use, or give the file, ListMe, for a list of files that can be opened.\n");
  
  cin >> filename;
  if (filename == "ListMe")
  {
    printf("This feature is still under construction\n");
    exit(1);
  }
  fout.open(filename.c_str());
  if (fout.fail())
  {
    printf("Opening file %s has failed\n", filename.c_str());
    exit(1);
  }

  fout >> size;
  Romanji.resize(size);
  Definition.resize(size);
  while (fout >> tmp1 >> tmp2)
  {
    Romanji[i] = tmp1;
    Definition[i] = tmp2;
    i++;
  }

  fout.close();
 
  Random = randomize(size);
  i = flashMenu();
    
  if (i == 1)
    FlashCard_write(Romanji, Definition, Random, 1);  
  else if (i == 2)
    FlashCard_write(Definition, Romanji, Random, 1);
  else if (i == 3)
    FlashCard_selfcheck(Romanji, Definition, Random);  
  else if (i == 4)
    FlashCard_selfcheck(Definition, Romanji, Random);
  
  return;
}

int flashMenu()
{
  int i;


  i = -1;
  while (i != 1 || i != 2 || i != 3 || i != 4)
  {
    printf("Do you want to go from...\n");
    printf("1. Japanese -> English - typing\n");
    printf("2. English -> Japanese - typing\n");
    printf("3. Japanese -> English - self-check\n");
    printf("4. English -> Japanese - self-check\n");
    cin >> i;
    if (i == 1)
      return 1;
    else if (i == 2)
      return 2;
    else if (i == 3) 
      return 3;
    else if (i == 4)
      return 4;
    else
      printf("Please choose a valid option\n");
  }

  printf("Problem in flashMenu(). Ending program.\n");
  exit(1);
}


void createList()
{
  int maxlen;
  int numlines;
  int i, j, spaces;
  string romanji;
  string definition;
  string filename;
  vector <string> R;
  vector <string> D;
  ofstream fout;


  numlines = 0;
  maxlen = 0;

  printf("Please put the Kana word/phrase in first - all as one word, use _ if needed - then put a space and the definition, all as a single word or phrase.\n");
  printf("When finished type Done Done to exit the list creation and name the file\n");
  while (1)
  {
    cin >> romanji >> definition;
    if (romanji == "Done")
      break;

    numlines++;
    if (romanji.size() > maxlen)
      maxlen = romanji.size();
    
    R.push_back(romanji);
    D.push_back(definition);    
  }

  printf("Please specify what to call your new file\n");
  cin >> filename;

  fout.open(filename.c_str());
  if (fout.fail())
  {
    printf("error opening the file\nExiting...\n");
    exit(1);
  }

  fout << numlines <<endl;
  for (i = 0; i < numlines; i++)
  {
     spaces = maxlen - R[i].size();
     fout << R[i];
     for (j = 0; j < spaces + 1; j++)
       fout <<" ";
     fout << D[i] <<endl;
  }

  fout.close();  

}


vector <int> randomize(int numarg)
{
  int i, tmp, rn;
  vector <int> random;

  srand48(time(0));
  for (i = 0; i < numarg; i++)
    random.push_back(i);
  for (i = random.size() - 1; i >= 0; i--)
  {
    rn = lrand48()%(i+1);
    tmp = random[i];
    random[i] = random[rn];
    random[rn] = tmp;
  }  

  return random;
}

void FlashCard_selfcheck(vector <string>& R, vector <string>& D, vector <int>& N)
{
  int i;
  cin.get(); //hacky fix to stop the first answer from priting
  for (i = 0; i < R.size(); i++)
  {
    printf("%s -", R[N[i]].c_str());
    if (cin.get() == '\n')
      printf("   %s\n", D[N[i]].c_str());
  }
  printf("\n\nEnd of Cards\n");
}

void FlashCard_write(vector <string>& R, vector <string>& D, vector <int>& N, int cond)
{
  int i, correct, wrong;
  string answer;

  correct = 0;
  wrong = 0;
  for (i = 0; i < R.size(); i++)
  {
    printf("%s - ", R[N[i]].c_str());
    cin >> answer;
    if (answer == D[N[i]])
      correct++;
    else
    {
      if (cond == 1)
      {
        wrong++;
        printf("Incorrect. The correct answer is %s\n", D[N[i]].c_str());
      }
    }
  }
  if (cond == 1)
    printf("You got %d of %d correct!\n", correct, correct + wrong);

}

void ListMe()
{
  DIR *d;
  struct dirent *de;
  char * name;

  name = (char *) malloc(sizeof(char)* 1 + 1);
  strcpy(name, ".");

  d = opendir("tmp\0");
  if (d == NULL)
  {
    fprintf(stderr, "Error opening the current directory list...Exiting...\n");
    perror("stuff");
    exit (1);
  }
  for (de = readdir(d); de != NULL; de = readdir(d))
  {
    printf("calling sprintf, %s\n", de->d_name);

  }

}
