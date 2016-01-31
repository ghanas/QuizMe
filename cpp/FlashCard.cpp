#include "FlashCard.h"
using namespace std;

int main()
{
  int choice;

  choice = menu();
  if (choice <= 0 || choice > 3)
  {
    printf("This has not yet been implimented.\nExiting...\n");
    exit(1);
  }
  if (choice == 1)
    createList();
  if (choice == 2)
    oneList();
  if (choice == 3)
    ListMe();

  return 0;

}
